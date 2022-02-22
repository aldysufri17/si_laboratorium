<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = DB::table('barang')->paginate(5);
        return view('backend.barang.index', ['barang' => $barang]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.barang.add');
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
            'nama'      => 'required',
            'berat'     => 'required|int',
            'tipe'      => 'required',
            'tgl_masuk' => 'required',
            'show'      => 'required|in:0,1',
            'lokasi'    => 'required',
            'kondisi'   => 'required'
        ], [
            'required' => ':attribute Bagian ini wajib diisi',
        ]);

        if ($request->gambar) {
            $gambar = $request->gambar;
            $new_gambar = date('Y-m-d') . "-" . $request->nama . "-" . $request->tipe . "." . $gambar->getClientOriginalExtension();
            $destination = storage_path('app/public/barang');
            $gambar->move($destination, $new_gambar);
            $barang = Barang::create([
                'nama'          => $request->nama,
                'berat'         => $request->berat,
                'tipe'          => $request->tipe,
                'tgl_masuk'     => $request->tgl_masuk,
                'show'          => $request->show,
                'lokasi'        => $request->lokasi,
                'kondisi'       => $request->kondisi,
                'gambar'        => $new_gambar,
            ]);
        } else {
            $barang = Barang::create([
                'nama'          => $request->nama,
                'berat'         => $request->berat,
                'tipe'          => $request->tipe,
                'tgl_masuk'     => $request->tgl_masuk,
                'show'          => $request->show,
                'lokasi'        => $request->lokasi,
                'kondisi'       => $request->kondisi,
            ]);
        }

        if ($barang) {
            return redirect()->route('barang.index')->with(['success', 'Barang berhasil ditambah']);
        } else {
            return redirect()->route('barang.index')->with(['error', 'Barang gagal ditambah']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang)
    {
        return view('backend.barang.detail', compact('barang'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit(Barang $barang)
    {
        return view('backend.barang.edit', compact('barang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama'      => 'required',
            'berat'     => 'required|int',
            'tipe'      => 'required',
            'tgl_masuk' => 'required',
            'show'      => 'required|in:0,1',
            'lokasi'    => 'required',
            'kondisi'   => 'required'
        ], [
            'required' => ':attribute Bagian ini wajib diisi',
        ]);
        if ($request->gambar) {
            if ($barang->gambar) {
                unlink(storage_path('app/public/barang/' . $barang->gambar));
            }
            $gambar = $request->gambar;
            $new_gambar = date('Y-m-d') . "-" . $request->nama . "-" . $request->tipe . "." . $gambar->getClientOriginalExtension();
            $destination = storage_path('app/public/barang');
            $gambar->move($destination, $new_gambar);
            $barang_update = Barang::whereid($barang->id)->update([
                'nama'          => $request->nama,
                'berat'         => $request->berat,
                'tipe'          => $request->tipe,
                'tgl_masuk'     => $request->tgl_masuk,
                'show'          => $request->show,
                'lokasi'        => $request->lokasi,
                'kondisi'       => $request->kondisi,
                'gambar'        => $new_gambar,
            ]);
        } else {
            $barang_update = Barang::whereid($barang->id)->update([
                'nama'          => $request->nama,
                'berat'         => $request->berat,
                'tipe'          => $request->tipe,
                'tgl_masuk'     => $request->tgl_masuk,
                'show'          => $request->show,
                'lokasi'        => $request->lokasi,
                'kondisi'       => $request->kondisi,
            ]);
        }
        if ($barang_update) {
            return redirect()->route('barang.index')->with('success', 'Barang Berhasil diperbarui!.');
        } else {
            return redirect()->route('barang.index')->with('error', 'Barang Gagal diperbarui!.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {
        $barang = Barang::whereid($barang->id)->delete();
        if ($barang) {
            return redirect()->route('barang.index')->with('success', 'Barang Berhasil dihapus!.');
        } else {
            return redirect()->route('barang.index')->with('error', 'Barang Gagal dihapus!.');
        }
    }
}
