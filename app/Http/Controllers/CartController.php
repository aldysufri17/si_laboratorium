<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Cart;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;

        // // Disetujui
        // $setujui = Peminjaman::where('user_id', $user_id)->where('status', 2)->get();
        // if ($setujui) {
        //     $request->session()->flash('in', "berhasil disetujui !!");
        // }
        // // Ditolak
        // $tolak = Peminjaman::where('user_id', $user_id)->where('status', 1)->get();
        // if ($tolak) {
        //     $request->session()->flash('tolak', "ditolak !!");
        // }
        // // Telat
        // $telat = Peminjaman::where('user_id', $user_id)->where('status', 3)->get();
        // if ($telat) {
        //     $request->session()->flash('telat', "Telat");
        // }

        $cart = Cart::where('user_id', $user_id)->where('status', 0)->paginate(4);

        return view('frontend.cart', compact('cart'));
        // dd($peminjaman);
    }

    public function detail($id_brg)
    {
        $barang = Barang::whereId($id_brg)->first();
        return view('frontend.detail', compact('barang'));
    }

    public function store($id)
    {
        if (Auth::check()) {
            $cart = Cart::create([
                'user_id' => Auth::user()->id,
                'barang_id' => $id,
                'status' => 0,
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
        $cart = Cart::find($id)->delete();
        if ($cart) {
            return redirect()->route('cart')->with('success', 'Berhasil dihapus!.');
        } else {
            return redirect()->route('cart')->with('error', 'Gagal dihapus!.');
        }
    }

    public function pengajuan($id)
    {
        $barang = Barang::whereId($id)->first();
        $peminjaman = Peminjaman::where('barang_id', $id)->paginate(5);
        return view('frontend.form-pengajuan', compact('barang', 'peminjaman'));
    }
}
