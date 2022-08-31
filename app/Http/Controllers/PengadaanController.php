<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pengadaan;
use Illuminate\Http\Request;

class PengadaanController extends Controller
{

    public function index()
    {
        $pengadaan = Pengadaan::paginate(5);
        return view('backend.barang.pengadaan.index', compact('pengadaan'));
    }

    public function create()
    {
        return view('backend.barang.pengadaan.add');
    }

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

    public function edit(Pengadaan $pengadaan)
    {
        return view('backend.barang.pengadaan.edit', compact('pengadaan'));
    }

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

    public function destroy($id, Request $request)
    {
        $id = $request->delete_id;
        if ($id > 5) {
            return redirect()->route('satuan.index')->with(['success', 'Pengadaan berhasil dihapus']);
        } else {
            $barang = Barang::where('satuan_id', $id)->get();
            if ($barang->isNotEmpty()) {
                return redirect()->route('satuan.index')->with(['success', 'Pengadaan berhasil dihapus']);
            } else {
                $pengadaan = Pengadaan::whereId($id)->delete();
                if ($pengadaan) {
                    return redirect()->route('pengadaan.index')->with(['success', 'Pengadaan berhasil dihapus']);
                } else {
                    return redirect()->route('pengadaan.index')->with(['error', 'Pengadaan gagal dihapus']);
                }
            }
        }
    }
}
