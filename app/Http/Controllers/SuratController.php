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
        $ceksurat = Surat::where('user_id', $id)->where('status', 2)->first();
        if ($ceksurat) {
            return redirect()->route('surat.index')->with('warning', 'Hapus surat, kemudian lakukan pengajuan lagi!.');
        } else {
            $peminjaman = Peminjaman::where('user_id', $id)->where('status', '<', 4)->get();
            if ($peminjaman->isEmpty()) {
                $surat = Surat::create([
                    'user_id' => $id,
                    'status' => 0
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
        $name = Auth::user()->name;
        $nim = Auth::user()->nim;
        $alamat = Auth::user()->alamat;
        $pdf = PDF::loadview('frontend.surat-bebas', ['name' => $name, 'nim' => $nim, 'alamat' => $alamat]);
        // return view('frontend.surat-bebas', ['name' => $name, 'nim' => $nim, 'alamat' => $alamat]);
        $surat = Surat::whereId($id)->where('status', 2)->get();
        if ($surat->isEmpty()) {
            return redirect()->back()->with('info', 'Pengajuan belum disetujui Admin!.');
        }
        return $pdf->download("Surat Bebas Lab" . "_" . $name . '_' . $nim . '.pdf');
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
}
