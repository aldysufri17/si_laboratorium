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
            'nama_satuan' => 'required',
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

        $max = Satuan::max('id');
        $kode = $max + 1;
        if (strlen($kode) == 1) {
            $kode_id = "ST-000" . $kode;
        } else if (strlen($kode) == 2) {
            $kode_id = "ST-00" . $kode;
        } else if (strlen($kode) == 3) {
            $kode_id = "ST-0" . $kode;
        } else if (strlen($kode) == 4) {
            $kode_id = "ST-" . $kode;
        } else {
            $kode_id = $kode;
        }

        $satuan = Satuan::create([
            'id'  => $kode,
            'nama_satuan' => $request->nama_satuan,
            'kategori_lab' => $kategori_lab,
            'kode' => $kode_id,
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
            'nama_satuan' => 'required'
        ]);

        $satuan = Satuan::whereId($id)->update([
            'nama_satuan' => $request->nama_satuan,
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
