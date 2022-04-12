<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role_id == 3) {
            $kategori_lab = 1;
        } elseif (Auth::user()->role_id == 4) {
            $kategori_lab = 2;
        } elseif (Auth::user()->role_id == 5) {
            $kategori_lab = 3;
        } elseif (Auth::user()->role_id == 6) {
            $kategori_lab = 4;
        }
        $satuan = Satuan::where('kategori_lab', $kategori_lab)->paginate(5);
        return view('backend.barang.satuan.index', compact('satuan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.barang.satuan.add');
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
        ]);

        if (Auth::user()->role_id == 3) {
            $kategori_lab = 1;
        } elseif (Auth::user()->role_id == 4) {
            $kategori_lab = 2;
        } elseif (Auth::user()->role_id == 5) {
            $kategori_lab = 3;
        } elseif (Auth::user()->role_id == 6) {
            $kategori_lab = 4;
        }

        $satuan = Satuan::create([
            'nama' => $request->nama,
            'kategori_lab' => $kategori_lab,
        ]);

        if ($satuan) {
            return redirect()->route('satuan.index')->with(['success', 'Satuan berhasil ditambah']);
        } else {
            return redirect()->route('satuan.index')->with(['error', 'Satuan gagal ditambah']);
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
    public function edit(Satuan $satuan)
    {
        return view('backend.barang.satuan.edit', compact('satuan'));
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
            'nama' => 'required'
        ]);

        $satuan = Satuan::whereId($id)->update([
            'nama' => $request->nama,
        ]);
        if ($satuan) {
            return redirect()->route('satuan.index')->with(['success', 'Satuan berhasil diedit']);
        } else {
            return redirect()->route('satuan.index')->with(['error', 'Satuan gagal diedit']);
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
        $satuan = Satuan::whereId($id)->delete();
        if ($satuan) {
            return redirect()->route('satuan.index')->with(['success', 'Satuan berhasil dihapus']);
        } else {
            return redirect()->route('satuan.index')->with(['error', 'Satuan gagal dihapus']);
        }
    }
}
