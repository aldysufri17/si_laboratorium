<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SatuanController extends Controller
{
    public $lab;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->lab = Auth::user()->laboratorium_id;
            return $next($request);
        });
    }

    public function index()
    {
        $satuan = Satuan::where('laboratorium_id', $this->lab)->paginate(5);
        return view('backend.barang.satuan.index', compact('satuan'));
    }

    public function create()
    {
        return view('backend.barang.satuan.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required',
        ]);

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
            'laboratorium_id' => $this->lab,
            'kode' => $kode_id,
        ]);

        if ($satuan) {
            return redirect()->route('satuan.index')->with(['success', 'Satuan berhasil ditambah']);
        } else {
            return redirect()->route('satuan.index')->with(['error', 'Satuan gagal ditambah']);
        }
    }

    public function edit(Satuan $satuan)
    {
        return view('backend.barang.satuan.edit', compact('satuan'));
    }

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

    public function destroy($id, Request $request)
    {
        $id = $request->delete_id;
        $barang = Barang::where('satuan_id', $id)->get();
        if ($barang->isNotEmpty()) {
            return redirect()->route('satuan.index')->with(['success', 'Satuan berhasil dihapus']);
        } else {
            $satuan = Satuan::whereId($id)->delete();
            if ($satuan) {
                return redirect()->route('satuan.index')->with(['success', 'Satuan berhasil dihapus']);
            } else {
                return redirect()->route('satuan.index')->with(['error', 'Satuan gagal dihapus']);
            }
        }
    }
}
