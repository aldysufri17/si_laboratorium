<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Keranjang;
use App\Models\Peminjaman;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $cart = Keranjang::where('user_id', $user_id)->where('status', 0)->get();

        return view('frontend.cart', compact('cart'));
    }

    public function detail($id_brg)
    {
        $barang = Barang::whereId($id_brg)->first();
        return view('frontend.detail', compact('barang'));
    }

    public function store(Request $request, $id)
    {
        if (Auth::check()) {
            $cart = Keranjang::create([
                'user_id' => Auth::user()->id,
                'barang_id' => $id,
                'status' => 0,
                'jumlah' => $request->jumlah,
            ]);
            if ($cart) {
                return redirect()->route('cart')->with('success', 'Barang berhasil ditambah!.');
            } else {
                return redirect()->route('cart')->with('error', 'Barang Gagal ditambah!.');
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

    // public function checkout(Request $request, $id)
    // {
    //     $id_cart = $request->ckd_chld;
    //     $peminjaman = Keranjang::whereIn('id', $id_cart)->get();
    //     foreach ($peminjaman as $data) {
    //         $peminjaman = Peminjaman::create([
    //             'id'            => substr(str_shuffle("0123456789"), 0, 8),
    //             'user_id'       => $id,
    //             'barang_id'     => $data->barang_id,
    //             'tgl_start'     => $data->tgl_start,
    //             'tgl_end'       => $data->tgl_end,
    //             'jumlah'        => $data->jumlah,
    //             'kategori_lab'  => $data->kategori_lab,
    //             'alasan'        => $data->alasan,
    //             'status'        => 0,
    //             'date'          => date('Y-m-d')
    //         ]);
    //     }
    //     foreach ($id_cart as $id) {
    //         $keranjang = Keranjang::where('id', $id)->update(['status' => 1]);
    //     }

    //     if ($keranjang) {
    //         return redirect()->route('daftar.pinjaman')->with('success', 'Pengajuan Berhasil ditambah!.');
    //     } else {
    //         return redirect()->route('daftar.pinjaman')->with('error', 'Gagal ditambah!.');
    //     }
    // }

    public function update(Request $request)
    {
        $id_cart = json_decode($request->cart);
        $user_id = Auth::user()->id;
        $keranjang = Keranjang::whereIn('id', $id_cart)->get();
        foreach ($keranjang as $data) {
            $peminjaman = Peminjaman::create([
                'id'            => substr(str_shuffle("0123456789"), 0, 8),
                'user_id'       => $user_id,
                'barang_id'     => $data->barang_id,
                'tgl_start'     => $request->tgl_start,
                'tgl_end'       => $request->tgl_end,
                'jumlah'        => $data->jumlah,
                'kategori_lab'  => $data->kategori_lab,
                'alasan'        => $request->alasan,
                'status'        => 0,
                'date'          => date('Y-m-d')
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

    public function decrement(Request $request)
    {
        $cart_id = $request->id;
        $jml = Keranjang::where('id', $cart_id)->value('jumlah');
        if ($jml <= 1) {
            Keranjang::where('id', $cart_id)->update(['jumlah' => 1]);
        } else {
            Keranjang::where('id', $cart_id)->update(['jumlah' => $jml - 1]);
        }
        $total = Keranjang::where('id', $cart_id)->value('jumlah');
        return response()->json(
            [
                'jumlah' => $total,
            ]
        );
    }
    public function increment(Request $request)
    {
        $cart_id = $request->id;
        $jml = Keranjang::where('id', $cart_id)->value('jumlah');
        Keranjang::where('id', $cart_id)->update(['jumlah' => $jml + 1]);
        $total = Keranjang::where('id', $cart_id)->value('jumlah');
        return response()->json(
            [
                'jumlah' => $total,
            ]
        );
    }
}
