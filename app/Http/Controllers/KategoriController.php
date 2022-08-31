<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public $lab;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->lab = Auth::user()->post;
            return $next($request);
        });
    }

    public function index()
    {
        $kategori = Kategori::where('laboratorium_id', $this->lab)->paginate(5);
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
            'laboratorium_id' => $this->lab,
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

    public function destroy($id, Request $request)
    {
        $id = $request->delete_id;
        $barang = Barang::where('kategori_id', $id)->first();
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
