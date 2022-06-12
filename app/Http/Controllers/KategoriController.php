<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
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
        $kategori = Kategori::where('kategori_lab', $kategori_lab)->paginate(5);
        return view('backend.barang.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('backend.barang.kategori.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required',
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

        $max = Kategori::max('id');
        $kode = $max + 1;
        if (strlen($kode) == 1) {
            $kode_id = "KT-000" . $kode;
        } else if (strlen($kode) == 2) {
            $kode_id = "KT-00" . $kode;
        } else if (strlen($kode) == 3) {
            $kode_id = "KT-0" . $kode;
        } else if (strlen($kode) == 4) {
            $kode_id = "KT-" . $kode;
        } else {
            $kode_id = $kode;
        }

        $kategori = Kategori::create([
            'id'  => $kode,
            'kode' => $kode_id,
            'nama_kategori' => $request->nama_kategori,
            'kategori_lab' => $kategori_lab,
        ]);

        if ($kategori) {
            return redirect()->route('kategori.index')->with(['success', 'Kategori berhasil ditambah']);
        } else {
            return redirect()->route('kategori.index')->with(['error', 'Kategori gagal ditambah']);
        }
    }

    public function edit(Kategori $kategori)
    {
        return view('backend.barang.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required'
        ]);

        $kategori = Kategori::whereId($id)->update([
            'nama_kategori' => $request->nama_kategori,
        ]);
        if ($kategori) {
            return redirect()->route('kategori.index')->with(['success', 'Kategori berhasil diedit']);
        } else {
            return redirect()->route('kategori.index')->with(['error', 'Kategori gagal diedit']);
        }
    }

    public function destroy($id)
    {
        $barang = Barang::where('satuan_id', $id)->first();
        if ($barang) {
            return redirect()->route('kategori.index')->with(['error', 'Kategori Masih digunakan!']);
        }
        $kategori = Kategori::whereId($id)->delete();
        if ($kategori) {
            return redirect()->route('kategori.index')->with(['success', 'Kategori berhasil dihapus']);
        } else {
            return redirect()->route('kategori.index')->with(['error', 'Kategori gagal dihapus']);
        }
    }
}
