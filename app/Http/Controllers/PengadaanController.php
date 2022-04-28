<?php

namespace App\Http\Controllers;

use App\Models\Pengadaan;
use Illuminate\Http\Request;

class PengadaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengadaan = Pengadaan::paginate(5);
        return view('backend.barang.pengadaan.index', compact('pengadaan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.barang.pengadaan.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pengadaan' => 'required',
        ]);
        $max = Pengadaan::max('id');
        $kode = $max + 1;
        if (strlen($kode) == 1) {
            $kode_id = "TK-000" . $kode;
        } else if (strlen($kode) == 2) {
            $kode_id = "TK-00" . $kode;
        } else if (strlen($kode) == 3) {
            $kode_id = "TK-0" . $kode;
        } else if (strlen($kode) == 4) {
            $kode_id = "TK-" . $kode;
        } else {
            $kode_id = $kode;
        }
        $pengadaan = Pengadaan::create([
            'id'  => $kode,
            'nama_pengadaan' => $request->nama_pengadaan,
            'kode' => $kode_id,
        ]);

        if ($pengadaan) {
            return redirect()->route('pengadaan.index')->with(['success', 'Jenis Pengadaan berhasil ditambah']);
        } else {
            return redirect()->route('pengadaan.index')->with(['error', 'Jenis Pengadaan gagal ditambah']);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengadaan $pengadaan)
    {
        return view('backend.barang.pengadaan.edit', compact('pengadaan'));
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
        $request->validate([
            'nama_pengadaan' => 'required'
        ]);

        $pengadaan = Pengadaan::whereId($id)->update([
            'nama_pengadaan' => $request->nama_pengadaan,
        ]);
        if ($pengadaan) {
            return redirect()->route('pengadaan.index')->with(['success', 'Jenis Pengadaan berhasil diedit']);
        } else {
            return redirect()->route('pengadaan.index')->with(['error', 'Jenis Pengadaan gagal diedit']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pengadaan = Pengadaan::whereId($id)->delete();
        if ($pengadaan) {
            return redirect()->route('pengadaan.index')->with(['success', 'Pengadaan berhasil dihapus']);
        } else {
            return redirect()->route('pengadaan.index')->with(['error', 'Pengadaan gagal dihapus']);
        }
    }
}
