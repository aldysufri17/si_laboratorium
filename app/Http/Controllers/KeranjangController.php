<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Keranjang;
use App\Models\Peminjaman;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $cart = Peminjaman::where('user_id', $user_id)->where('status', -1)->orderBy('id', 'DESC')->get();
        return view('frontend.cart', compact('cart'));
    }

    public function detail($id_brg)
    {
        $barang = Barang::whereId($id_brg)->first();
        return view('frontend.detail', compact('barang'));
    }

    public function store(Request $request, $id)
    {
        $user = Auth::user()->id;
        $stock = Barang::whereId($id)->value('stock');
        if (Auth::check()) {
            $cek_keranjang = Peminjaman::where('user_id', $user)
                ->where('barang_id', $id)
                ->where('status', -1)
                ->first();
            $cekPengajuan =  Peminjaman::where('user_id', $user)
                ->where('barang_id', $id)
                ->whereBetween('status', [0, 3])
                ->get();
            $sum = array_sum($cekPengajuan->pluck('jumlah')->toArray());
            if ($cek_keranjang) {
                if ($cekPengajuan->IsNotEmpty()) {
                    if ($stock < $request->jumlah + $sum) {
                        return redirect()->back()->with('stock', "Anda sudah memilih barang ini sebanyak $sum Unit , Stock tidak mencukupi!.");
                    } else {
                        $cart = Peminjaman::create([
                            'user_id'           => $user,
                            'barang_id'         => $id,
                            'jumlah'            => $request->jumlah,
                            'status'            => -1,
                        ]);
                    }
                } else {
                    if ($stock < $request->jumlah + $cek_keranjang->jumlah) {
                        return redirect()->back()->with('stock', 'Stock tidak mencukupi!.');
                    } else {
                        $cart = Peminjaman::whereId($cek_keranjang->id)->update([
                            'jumlah' => $request->jumlah + $cek_keranjang->jumlah
                        ]);
                    }
                }
            } else {
                if ($cekPengajuan->IsNotEmpty()) {
                    if ($stock < $request->jumlah + $sum) {
                        return redirect()->back()->with('stock', "Anda sudah memilih barang ini sebanyak $sum Unit , Stock tidak mencukupi!.");
                    } else {
                        $cart = Peminjaman::create([
                            'user_id'           => $user,
                            'barang_id'         => $id,
                            'jumlah'            => $request->jumlah,
                            'status'            => -1,
                        ]);
                    }
                } else {
                    if ($stock < $request->jumlah) {
                        return redirect()->back()->with('stock', 'Stock tidak mencukupi!.');
                    } else {
                        $cart = Peminjaman::create([
                            'user_id'           => $user,
                            'barang_id'         => $id,
                            'jumlah'            => $request->jumlah,
                            'status'            => -1,
                        ]);
                    }
                }
            }
            if ($cart) {
                return redirect()->route('cart')->with('success', 'Barang berhasil ditambah!.');
            } else {
                return redirect()->route('cart')->with('error', 'Barang Gagal ditambah!.');
            }
        } else {
            return redirect()->route('login')->with('info', 'Anda harus login dahulu!.');
        }
    }

    public function destroy($id, Request $request)
    {
        $cart = Peminjaman::find($request->delete_id)->delete();
        if ($cart) {
            return redirect()->route('cart')->with('success', 'Berhasil dihapus!.');
        } else {
            return redirect()->route('cart')->with('error', 'Gagal dihapus!.');
        }
    }

    public function decrement(Request $request)
    {
        $cart_id = $request->id;
        $jml = Peminjaman::where('id', $cart_id)->value('jumlah');
        if ($jml <= 1) {
            Peminjaman::where('id', $cart_id)->update(['jumlah' => 1]);
        } else {
            Peminjaman::where('id', $cart_id)->update(['jumlah' => $jml - 1]);
        }
    }

    public function increment($id, Request $request)
    {
        $cart_id = $request->id; // id peminjaman
        $barang = Peminjaman::where('id', $cart_id)->value('barang_id'); // id barang dari peminjaman
        $jml = Peminjaman::where('id', $cart_id)->value('jumlah'); //jumlah dari peminjaman
        $stock = Barang::where('id', $barang)->value('stock');
        $cekPengajuan =  Peminjaman::where('user_id', Auth::user()->id)
            ->where('barang_id', $barang)
            ->whereBetween('status', [0, 3])
            ->get();
        $sum = array_sum($cekPengajuan->pluck('jumlah')->toArray());
        if ($id == 0) {
            $pemjum = $sum + $jml;
        } else {
            $pemjum = $sum;
        }

        if ($cekPengajuan) {
            if ($pemjum >= $stock) {
                Peminjaman::where('id', $cart_id)->update(['jumlah' => $jml]);
            } else {
                Peminjaman::where('id', $cart_id)->update(['jumlah' => $jml + 1]);
            }
        } else {
            if ($jml >= $stock) {
                Peminjaman::where('id', $cart_id)->update(['jumlah' => $stock]);
            } else {
                Peminjaman::where('id', $cart_id)->update(['jumlah' => $jml + 1]);
            }
        }
        // $cart_id = $request->id;
        // $barang = Peminjaman::where('id', $cart_id)->value('barang_id');
        // $jml = Peminjaman::where('id', $cart_id)->value('jumlah');
        // $stock = Barang::where('id', $barang)->value('stock');
        // if ($jml >= $stock) {
        //     Peminjaman::where('id', $cart_id)->update(['jumlah' => $stock]);
        // } else {
        //     Peminjaman::where('id', $cart_id)->update(['jumlah' => $jml + 1]);
        // }
    }

    public function cartSelected(Request $request)
    {
        $id = $request->ckd;
        $output = "";
        $barang = Peminjaman::whereIn('id', $id)->get();
        foreach ($barang as $data) {
            $output .= '<tr>' .
                '<td>' . $data->barang->kode_barang . '</td>' .
                '<td>' . $data->barang->nama . "-" . $data->barang->tipe . '</td>' .
                '<td>' . $data->jumlah . $data->barang->satuan->nama_satuan . '</td>' .
                '</tr>';
        }
        return Response($output);
    }
}
