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
                ->select('barang_id', DB::raw('count(`barang_id`) as total'))
                ->groupBy('barang_id')
                ->get();
            foreach ($duplicated as $record) {
                if ($record->total = 1) {
                    return redirect()->back()->with('max', 'Barang sudah dipilih!.');
                }
            }

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

    public function pengajuan($id)
    {
        $user_id = Auth::user()->id;
        $keranjang = Keranjang::where('barang_id', $id)->where('user_id', $user_id)->first();
        $barang = Barang::whereId($id)->first();
        $peminjaman = Peminjaman::where('barang_id', $id)->where('user_id', $user_id)->paginate(5);
        return view('frontend.form-pengajuan', compact('barang', 'peminjaman', 'keranjang'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'tgl_start' => 'required',
            'tgl_end' => 'required',
            'tgl_alasan' => 'required',
            'nama_keranjang' => 'required'
        ]);
        $id_cart = json_decode($request->cart);
        $user_id = Auth::user()->id;
        $keranjang = Keranjang::whereIn('id', $id_cart)->get();
        $kode_peminjaman = $user_id . substr(str_shuffle("0123456789"), 0, 8);
        $nama_keranjang = str_replace(' ', '_', strtolower($request->nama_keranjang));
        $cek = Peminjaman::where('nama_keranjang', $nama_keranjang)->where('status', '<', 4)->where('user_id', $user_id)->first();
        if ($cek->nama == $nama_keranjang) {
            return redirect()->back()->with('name', 'Nama Keranjang sudah ada...!!');
        } else {
            $keranjang_name = $nama_keranjang;
        }

        if ($request->tgl_end < $request->tgl_start || $request->tgl_start < date('Y-m-d')) {
            return redirect()->back()->with('eror', 'Tanggal peminjaman tidak falid...!!');
        }

        // dd($keranjang_name);
        foreach ($keranjang as $data) {
            $peminjaman = Peminjaman::create([
                'id'                => substr(str_shuffle("0123456789"), 0, 8),
                'kode_peminjaman'   => $kode_peminjaman,
                'nama_keranjang'    => $keranjang_name,
                'user_id'           => $user_id,
                'barang_id'         => $data->barang_id,
                'tgl_start'         => $request->tgl_start,
                'tgl_end'           => $request->tgl_end,
                'jumlah'            => $data->jumlah,
                'kategori_lab'      => $data->kategori_lab,
                'alasan'            => $request->alasan,
                'status'            => 0,
            ]);
        }
        foreach ($id_cart as $id) {
            Keranjang::where('id', $id)->update(['status' => 1]);
        }

        if ($peminjaman) {
            return redirect()->route('daftar.pinjaman')->with('success', 'Pengajuan Berhasil ditambah!.');
        } else {
            return redirect()->route('daftar.pinjaman')->with('error', 'Gagal ditambah!.');
        }






        // $barang = Barang::whereId($id)->first();
        // $stok = $barang->stock;
        // $kategori_lab = $barang->kategori_lab;
        // if ($request->jumlah > $stok) {
        //     return redirect()->back()->with('eror', 'Stok Barang tidak mencukupi...!!');
        // } elseif ($request->tgl_end < $request->tgl_start || $request->tgl_start < date('Y-m-d')) {
        //     return redirect()->back()->with('eror', 'Tanggal peminjaman tidak falid...!!');
        // } else {
        //     $request->validate([
        //         'jumlah' => 'required',
        //         'alasan' => 'required',
        //         'tgl_start' => 'required',
        //         'tgl_end' => 'required',
        //     ]);
        //     $user_id = Auth::user()->id;
        //     $keranjang = Keranjang::where('barang_id', $id)->where('user_id', $user_id)->update([
        //         'tgl_start'     => $request->tgl_start,
        //         'tgl_end'       => $request->tgl_end,
        //         'jumlah'        => $request->jumlah,
        //         'kategori_lab'  => $kategori_lab,
        //         'alasan'        => $request->alasan,
        //     ]);
        //     if ($keranjang) {
        //         return redirect()->route('cart')->with('success', 'Form Penggunaan Berhasil dibuat!.');
        //     } else {
        //         return redirect()->back()->with('error', 'Gagal ditambah');
        //     }
        // }
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
            Keranjang::where('id', $cart_id)->update(['jumlah' => $jml + 1]);
        } else {
            $cart_id = $request->id;
            $jml = Peminjaman::where('id', $cart_id)->value('jumlah');
            Peminjaman::where('id', $cart_id)->update(['jumlah' => $jml + 1]);
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
