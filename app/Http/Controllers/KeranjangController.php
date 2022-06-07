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
        $cart = Keranjang::where('user_id', $user_id)->where('status', 0)->orderBy('id', 'DESC')->get();

        return view('frontend.cart', compact('cart'));
    }

    public function detail($id_brg)
    {
        $barang = Barang::whereId($id_brg)->first();
        return view('frontend.detail', compact('barang'));
    }

    public function store(Request $request, $id)
    {
        $kategori_lab = Barang::whereId($id)->value('kategori_lab');
        $stock = Barang::whereId($id)->value('stock');
        if (Auth::check()) {
            // Cek duplicate data
            $duplicated = Keranjang::where('user_id', Auth::user()->id)
                ->where('status', 0)
                ->where('barang_id', $id)
                ->select('barang_id')
                ->groupBy('barang_id')
                ->first();
            if ($duplicated != null) {
                return redirect()->back()->with('max', 'Barang sudah dipilih!.');
            }
            // foreach ($duplicated as $record) {
            //     if ($record->total = 1) {
            //         return redirect()->back()->with('max', 'Barang sudah dipilih!.');
            //     }
            // }

            if ($stock < $request->jumlah) {
                return redirect()->back()->with('stock', 'Stock tidak mencukupi!.');
            } else {
                $cart = Keranjang::create([
                    'user_id' => Auth::user()->id,
                    'barang_id' => $id,
                    'status' => 0,
                    'jumlah' => $request->jumlah,
                    'kategori_lab' => $kategori_lab,
                ]);
                if ($cart) {
                    return redirect()->route('cart')->with('success', 'Barang berhasil ditambah!.');
                } else {
                    return redirect()->route('cart')->with('error', 'Barang Gagal ditambah!.');
                }
            }
        } else {
            return redirect()->route('login')->with('info', 'Anda harus login dahulu!.');
        }
    }

    public function destroy($id)
    {
        $cart = Keranjang::find($id)->delete();
        if ($cart) {
            return redirect()->route('cart')->with('success', 'Berhasil dihapus!.');
        } else {
            return redirect()->route('cart')->with('error', 'Gagal dihapus!.');
        }
    }

    public function decrement($status, Request $request)
    {
        if ($status == 0) {
            $cart_id = $request->id;
            $jml = Keranjang::where('id', $cart_id)->value('jumlah');
            if ($jml <= 1) {
                Keranjang::where('id', $cart_id)->update(['jumlah' => 1]);
            } else {
                Keranjang::where('id', $cart_id)->update(['jumlah' => $jml - 1]);
            }
        } else {
            $cart_id = $request->id;
            $jml = Peminjaman::where('id', $cart_id)->value('jumlah');
            if ($jml <= 1) {
                Peminjaman::where('id', $cart_id)->update(['jumlah' => 1]);
            } else {
                Peminjaman::where('id', $cart_id)->update(['jumlah' => $jml - 1]);
            }
        }
    }

    public function increment($status, Request $request)
    {
        if ($status == 0) {
            $cart_id = $request->id;
            $jml = Keranjang::where('id', $cart_id)->value('jumlah');
            $barang = Keranjang::where('id', $cart_id)->value('barang_id');
            $stock = Barang::where('id', $barang)->value('stock');
            if ($jml >= $stock) {
                Keranjang::where('id', $cart_id)->update(['jumlah' => $stock]);
            } else {
                Keranjang::where('id', $cart_id)->update(['jumlah' => $jml + 1]);
            }
        } else {
            $cart_id = $request->id;
            $barang = Peminjaman::where('id', $cart_id)->value('barang_id');
            $jml = Peminjaman::where('id', $cart_id)->value('jumlah');
            $stock = Barang::where('id', $barang)->value('stock');
            if ($jml >= $stock) {
                Peminjaman::where('id', $cart_id)->update(['jumlah' => $stock]);
            } else {
                Peminjaman::where('id', $cart_id)->update(['jumlah' => $jml + 1]);
            }
        }
    }

    public function cartSelected(Request $request)
    {
        $id = $request->ckd;
        $output = "";
        $barang = Keranjang::whereIn('id', $id)->get();
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
