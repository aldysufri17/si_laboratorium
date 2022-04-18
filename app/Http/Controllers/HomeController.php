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
            // Disetujui
            $peminjaman = Peminjaman::where('user_id', $user_id)->where('status', 2)->get();
            if ($peminjaman) {
                $request->session()->flash('in', "berhasil disetujui !!");
            }
            // Ditolak
            $tolak = Peminjaman::where('user_id', $user_id)->where('status', 1)->get();
            if ($tolak) {
                $request->session()->flash('tolak', "ditolak !!");
            }
            // Diaktifkan
            $aktif = Peminjaman::where('user_id', $user_id)->where('status', 3)->get();
            if ($aktif) {
                $request->session()->flash('aktif', "status aktif !!");
            }
            // Telat
            $telat = Peminjaman::where('user_id', $user_id)->where('status', 3)->get();
            if ($telat) {
                $request->session()->flash('telat', "Telat");
            }
            // dd($telat);
            return view('frontend.home', compact('peminjaman', 'aktif'), ['telat' => $telat, 'tolak' => $tolak]);
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
        if ($request->kategori_lab == 1 || $request->kategori_lab == "") {
            $lab = "Sistem Tertanam dan Robotika";
        } elseif ($request->kategori_lab == 2) {
            $lab = "Rekayasa Perangkat Lunak";
        } elseif ($request->kategori_lab == 3) {
            $lab = "Jaringan dan Keamanan Komputer";
        } elseif ($request->kategori_lab == 4) {
            $lab = "Multimedia";
        }

        if (Auth::check()) {
            $data = Peminjaman::where('user_id', Auth::user()->id)->where('status', '<', 4)->pluck('barang_id');
        }
        if ($request->kategori_lab) {
            if (Auth::check()) {
                $barang = Barang::where('show', 1)
                    ->where('kategori_lab', $request->kategori_lab)
                    ->whereNotIn('id', $data)
                    ->latest();
                // dd($barang);
            } else {
                $barang = Barang::where('show', 1)
                    ->where('kategori_lab', $request->kategori_lab)
                    ->latest();
            }

            if ($request->search) {
                $barang->where('nama', 'like', '%' . $request->search . '%');
            }
        } else {
            if (Auth::check()) {
                $barang = Barang::where('show', 1)
                    ->where('kategori_lab', 1)
                    ->whereNotIn('id', $data)
                    ->latest();
            } else {
                $barang = Barang::where('show', 1)
                    ->where('kategori_lab', 1)
                    ->latest();
            }
        }

        return view('frontend.search', ['barang' => $barang->paginate(7), 'lab' => $lab]);
    }

    public function detail($id)
    {
        $peminjaman = Peminjaman::where('barang_id', $id)->where('status', 3)->paginate(5);
        $barang = Barang::whereId($id)->first();
        return view('frontend.detail', compact('barang', 'peminjaman'));
    }

    public function riwayat()
    {
        $user_id = Auth::user()->id;
        $selesai = Peminjaman::with('barang')
            ->where('user_id',  $user_id)
            ->Where('status', 4)
            ->paginate(7);
        $aktif = Peminjaman::with('barang')
            ->where('user_id',  $user_id)
            ->Where('status', 3)
            ->paginate(7);
        return view('frontend.show-peminjaman', compact('aktif', 'selesai'));
    }

    public function langkahPeminjaman()
    {
        return view('frontend.langkah-peminjaman');
    }

    public function inventaris()
    {
        $barang = Barang::with('satuan', 'kategori')->where('show', 1)->paginate(8);;
        return view('frontend.inventaris', compact('barang'));
    }
}
