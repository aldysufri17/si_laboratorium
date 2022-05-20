<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = Auth::user()->id;
        $surat = Surat::with('user')->where('user_id', $id)->paginate(5);
        // dd($surat);
        // Disetujui
        $setujui = Surat::where('user_id', $id)->where('status', 2)->get();
        if ($setujui) {
            $request->session()->flash('in', "berhasil disetujui !!");
        }
        // Ditolak
        $tolak = Surat::where('user_id', $id)->where('status', 1)->get();
        if ($tolak) {
            $request->session()->flash('tolak', "ditolak !!");
        }
        $unduh = Surat::where('user_id', $id)->where('status', 2)->first();
        return view('frontend.surat', compact('surat', 'setujui', 'tolak', 'unduh'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $name = Auth::user()->name;
        $nim = Auth::user()->nim;
        $alamat = Auth::user()->alamat;
        $pdf = PDF::loadview('frontend.surat-bebas', ['name' => $name, 'nim' => $nim, 'alamat' => $alamat]);
        // return view('frontend.surat-bebas', ['name' => $name, 'nim' => $nim, 'alamat' => $alamat]);

        return $pdf->download("Surat Bebas Lab" . "_" . $name . '_' . $nim . '.pdf');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = Auth::user()->id;
        $ceksurat = Surat::where('user_id', $id)->first();
        if ($ceksurat) {
            return redirect()->route('surat.index')->with('warning', 'Hapus surat, kemudian lakukan pengajuan lagi!.');
        } else {
            $peminjaman = Peminjaman::where('user_id', $id)
                ->where('status', '=', 0)
                ->orwhere('status', '=', 2)
                ->orwhere('status', '=', 3)
                ->get();
            $kode = $id . substr(str_shuffle("0123456789"), 0, 8);
            if ($peminjaman->isEmpty()) {
                $surat = Surat::create([
                    'user_id'    => $id,
                    'kode'       => $kode,
                    'nama'       => $request->nama,
                    'nim'        => $request->nim,
                    'alamat'     => $request->alamat,
                    'no_telp'    => $request->mobile_number,
                    'status'     => 0
                ]);
                if ($surat) {
                    return redirect()->route('surat.index')->with('success', 'Surat berhasil diajukan!.');
                } else {
                    return redirect()->back()->with('error', 'Surat gagal diajukan!.');
                }
            } else {
                $request->session()->flash('gagal_surat', "PENGAJUAN GAGAL, MASIH TERDAPAT PROSES PEMINJAMAN.!");
                return redirect()->route('surat.index');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kode = $id;
        $surat = Surat::where('kode', $kode)->first();
        $pdf = PDF::loadview('frontend.surat-bebas', compact('surat'));
        return $pdf->download("Surat Bebas Lab" . "_" . $surat->nama . '_' . $surat->nim . '.pdf');
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
    public function update($id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $surat = Surat::whereId($id)->delete();
        if ($surat) {
            return redirect()->route('surat.index')->with('success', 'Surat berhasil dihapus!.');
        } else {
            return redirect()->back()->with('error', 'Surat Gagal dihapus!.');
        }
    }

    public function cekSuratBebas($kode)
    {
        $surat = Surat::where('kode', $kode)->where('status', 2)->get();
        $nama = $surat->first();
        if ($surat->isEmpty()) {
            return redirect('/')->with('info', "Surat Tidak Terdaftar");
        } else {
            return redirect('/')->with('info', "Surat Terdaftar Atas Nama $nama->nama/$nama->nim");
        }
    }
    public function cekSuratPeminjaman($kode)
    {
        $surat = Peminjaman::where('kode_peminjaman', $kode)->get();
        $nama = $surat->first();
        if ($surat->isEmpty()) {
            return redirect('/')->with('info', "Surat Tidak Terdaftar");
        } else {
            return redirect('/')->with('info', "Surat Terdaftar Atas Nama $nama->nama/$nama->nim");
        }
    }
}
