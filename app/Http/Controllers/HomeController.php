<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{

    public function credit()
    {
        return view('frontend.creadit');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $request->session()->flash('eror', "pengajuan belum disetujui !!!");
        // example:
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $peminjaman = Peminjaman::where('user_id', $user_id)->where('status', 0)->get();
            if ($peminjaman) {
                $total = Peminjaman::where('user_id', $user_id)->where('status', 0)->count();
                $request->session()->flash('in', "$total PENGAJUAN MASIH DALAM PROSES");
            }
            return view('frontend.home', compact('peminjaman'));
        }
        return view('frontend.home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.checkout');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ad()
    {
        $user_id = Auth::user()->id;
        $peminjaman = Peminjaman::with('barang')
            ->where('user_id',  $user_id)
            ->Where('status', '<', 0)
            ->paginate(7);
        return view('frontend.show-peminjaman', compact('peminjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
        if ($request->kategori_lab) {
            $barang = Barang::where('show', 1)->where('kategori_lab', $request->kategori_lab)->latest();
            if ($request->search) {
                $barang->where('nama', 'like', '%' . $request->search . '%');
            }
        } else {
            $barang = Barang::where('show', 1)->where('kategori_lab', 1)->latest();
        }

        return view('frontend.search', ['barang' => $barang->paginate(7)]);
    }

    public function detail($id)
    {
        $barang = Barang::whereId($id)->first();
        return view('frontend.detail', compact('barang'));
    }

    public function riwayat()
    {
        $user_id = Auth::user()->id;
        $peminjaman = Peminjaman::with('barang')
            ->where('user_id',  $user_id)
            ->Where('status', 4)
            ->paginate(7);
        return view('frontend.show-peminjaman', compact('peminjaman'));
    }

    public function langkahPeminjaman()
    {
        return view('frontend.langkah-peminjaman');
    }

    public function inventaris()
    {
        $barang = DB::table('barang')->where('show', 1)->paginate(5);;
        return view('frontend.inventaris', compact('barang'));
    }
}
