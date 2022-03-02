<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = Cart::with('user', 'barang')
            ->where('status', 2)
            ->paginate(5);
        return view('backend.peminjaman.index', compact('cart'));
    }

    public function peminjaman()
    {
        // $cart = Cart::all()->user;
        $cart = Cart::withCount('user')
            ->select('date', DB::raw('count(*) as total'))
            ->where('status', '=', 0)
            ->groupBy('date')
            ->paginate(5);
        return view('backend.peminjaman.cart.index', compact('cart'));
    }

    public function pengembalian()
    {
        // $cart = Cart::all()->user;
        $cart = Cart::withCount('user')
            ->select('date', DB::raw('count(*) as total'))
            ->where('status', '=', 0)
            ->groupBy('date')
            ->paginate(5);
        return view('backend.peminjaman.cart.index', compact('cart'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
    }

    public function detail($data)
    {
        $cart = Cart::with('user', 'barang')
            ->where('date', $data)
            ->where('status', '=', 0)
            ->paginate(5);
        return view('backend.peminjaman.cart.detail', compact('cart'));
    }

    public function status($user_id, $status)
    {
        $cart = Cart::whereId($user_id)->update(['status' => $status]);

        // Masssage
        if ($cart) {
            if ($status == 1) {
                return redirect()->back()->with('info', 'Peminjaman Berhasil di Batalkan!.');
            }
            return redirect()->back()->with('success', 'Peminjaman Berhasil di Setujui!.');
        } else {
            return redirect()->back()->with('error', 'Gagal diperbarui');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
