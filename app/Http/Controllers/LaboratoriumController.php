<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Inventaris;
use App\Models\Laboratorium;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class LaboratoriumController extends Controller
{
    public $id;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $laboratorium = Laboratorium::all();
        return view('backend.laboratorium.index', compact('laboratorium'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.laboratorium.add');
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
            'nama' => 'required',
            'kode' => 'required'
        ]);
        Laboratorium::create([
            'nama' => $request->nama,
            'kode' => $request->kode,
        ]);
        return redirect()->route('lab.index')->with('success', 'Laboratorium Berhasil ditambah!.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lab = Laboratorium::whereId($id)->first();
        $user = User::where('laboratorium_id', $id)->get();
        $barang = Barang::where('laboratorium_id', $id)->count();
        return view('backend.laboratorium.detail', compact('lab', 'user', 'barang'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lab = Laboratorium::find($id)->first();
        return view('backend.laboratorium.edit', compact('lab'));
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
            'nama' => 'required',
            'kode' => 'required'
        ]);
        Laboratorium::whereId($id)->update([
            'nama' => $request->nama,
            'kode' => $request->kode,
        ]);
        return redirect()->route('lab.index')->with('success', 'Laboratorium Berhasil diubah!.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $this->id = $request->delete_id;
        $peminjaman = Peminjaman::whereHas('barang', function ($q) {
            $q->where('laboratorium_id', $this->id);
        })->where('status', '<', 4)->get();

        if ($peminjaman->isNotEmpty()) {
            request()->session()->flash('active', "Laboratorium gagal dihapus, Barang masih dalam proses pinjaman");
            return redirect()->route('lab.index');
        }

        Barang::where('laboratorium_id', $this->id)->delete();
        Peminjaman::whereHas('barang', function ($q) {
            $q->where('laboratorium_id', $this->id);
        })->delete();
        Inventaris::whereHas('barang', function ($q) {
            $q->where('laboratorium_id', $this->id);
        })->delete();
        User::where('laboratorium_id', $this->id)->delete();
        $lab = Laboratorium::whereId($this->id)->delete();

        if ($lab) {
            return redirect()->route('lab.index')->with(['success', 'Laboratorium berhasil dihapus']);
        } else {
            return redirect()->route('lab.index')->with(['error', 'Laboratorium gagal dihapus']);
        }
    }
}
