<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Inventaris;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;
use App\Exports\BarangExport;
use App\Imports\BarangImport;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;


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
        if (Auth::user()->role_id == 3) {
            $kategori = 1;
        } elseif (Auth::user()->role_id == 4) {
            $kategori = 2;
        } elseif (Auth::user()->role_id == 5) {
            $kategori = 3;
        } elseif (Auth::user()->role_id == 6) {
            $kategori = 4;
        }

        if (Auth::user()->role_id == 2) {
            $barang = Barang::select('kategori', DB::raw('count(*) as total'))
                ->groupBy('kategori')
                ->paginate(5);
        } else {
            $barang = DB::table('barang')
                ->where('kategori', $kategori)
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }
        return view('backend.barang.index', ['barang' => $barang]);
    }

    public function adminBarang($data)
    {
        $barang = DB::table('barang')
            ->where('kategori', $data)
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        return view('backend.barang.admin-detail', ['barang' => $barang]);
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
            'satuan'      => 'required',
            'stock'     => 'required|int',
            'tipe'      => 'required',
            'tgl_masuk' => 'required',
            'show'      => 'required|in:0,1',
            'lokasi'    => 'required',
        ], [
            'required' => ':attribute wajib diisi',
        ]);

        if (Auth::user()->role_id == 3) {
            $kategori = 1;
        } elseif (Auth::user()->role_id == 4) {
            $kategori = 2;
        } elseif (Auth::user()->role_id == 5) {
            $kategori = 3;
        } elseif (Auth::user()->role_id == 6) {
            $kategori = 4;
        }

        if ($request->gambar) {
            $gambar = $request->gambar;
            $new_gambar = date('Y-m-d') . "-" . $request->nama . "-" . $request->tipe . "." . $gambar->getClientOriginalExtension();
            $destination = storage_path('app/public/barang');
            $gambar->move($destination, $new_gambar);
            $barang = Barang::create([
                'id'            => time(),
                'nama'          => $request->nama,
                'stock'         => $request->stock,
                'tipe'          => $request->tipe,
                'tgl_masuk'     => $request->tgl_masuk,
                'show'          => $request->show,
                'lokasi'        => $request->lokasi,
                'kategori'      => $kategori,
                'satuan'        => $request->satuan,
                'info'          => $request->info,
                'gambar'        => $new_gambar,
            ]);

            // Inventaris
            $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            Inventaris::create([
                'id'                => substr(str_shuffle("0123456789"), 0, 8),
                'barang_id'         => time(),
                'status'            => 1,
                'deskripsi'         => 'Baru',
                'kode_inventaris'   => 'IN' . $random,
                'masuk'             => $request->stock,
                'kategori'          => $kategori,
                'keluar'            => 0,
                'total'             => $request->stock,
            ]);
        } else {
            // Barang
            $barang = Barang::create([
                'id'            => time(),
                'nama'          => $request->nama,
                'stock'         => $request->stock,
                'tipe'          => $request->tipe,
                'satuan'        => $request->satuan,
                'tgl_masuk'     => $request->tgl_masuk,
                'show'          => $request->show,
                'lokasi'        => $request->lokasi,
                'kategori'      => $kategori,
                'info'          => $request->info,
            ]);

            // Inventaris
            $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            Inventaris::create([
                'id'                => substr(str_shuffle("0123456789"), 0, 8),
                'barang_id'         => time(),
                'status'            => 1,
                'deskripsi'         => 'Baru',
                'kode_inventaris'   => 'IN' . $random,
                'masuk'             => $request->stock,
                'kategori'          => $kategori,
                'keluar'            => 0,
                'total'             => $request->stock,
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
            'stock'     => 'required|int',
            'tipe'      => 'required',
            'satuan'    => 'required',
            'tgl_masuk' => 'required',
            'show'      => 'required|in:0,1',
            'lokasi'    => 'required',
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
                'stock'         => $request->stock,
                'tipe'          => $request->tipe,
                'tgl_masuk'     => $request->tgl_masuk,
                'show'          => $request->show,
                'lokasi'        => $request->lokasi,
                'satuan'        => $request->satuan,
                'info'          => $request->info,
                'gambar'        => $new_gambar,
            ]);
        } else {
            $barang_update = Barang::whereid($barang->id)->update([
                'nama'          => $request->nama,
                'stock'         => $request->stock,
                'tipe'          => $request->tipe,
                'satuan'        => $request->satuan,
                'tgl_masuk'     => $request->tgl_masuk,
                'show'          => $request->show,
                'lokasi'        => $request->lokasi,
                'info'        => $request->info,

            ]);
        }
        if ($barang_update) {
            return redirect()->route('barang.index')->with('success', 'Barang Berhasil diperbarui!.');
        } else {
            return redirect()->route('barang.index')->with('error', 'Barang Gagal diperbarui!.');
        }
    }

    public function damaged()
    {
        if (Auth::user()->role_id == 2) {
            $barang = Barang::whereNotNull('jml_rusak')
                ->select('kategori', DB::raw('count(*) as total'))
                // ->selectRaw(DB::raw("SUM(jml_rusak) as total"))
                ->groupBy('kategori')
                ->paginate(5);
            // dd($barang);
            return view('backend.barang.damaged', compact('barang'));
        } else {
            if (Auth::user()->role_id == 3) {
                $kategori = 1;
            } elseif (Auth::user()->role_id == 4) {
                $kategori = 2;
            } elseif (Auth::user()->role_id == 5) {
                $kategori = 3;
            } elseif (Auth::user()->role_id == 6) {
                $kategori = 4;
            }
            $barang = Barang::whereNotNull('jml_rusak')->where('kategori', $kategori)->paginate(5);
            return view('backend.barang.damaged', compact('barang'));
        }
    }

    public function adminDamaged($data)
    {
        $barang = Barang::whereNotNull('jml_rusak')->where('kategori', $data)->paginate(5);
        return view('backend.barang.admin-damaged', compact('barang'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy($barang)
    {

        $peminjaman = Peminjaman::where('barang_id', $barang)->where('status', '<', 4)->get();
        if ($peminjaman->isNotEmpty()) {
            request()->session()->flash('active', "Barang gagal dihapus, Masih terdapat transaksi peminjaman");
            return redirect()->route('barang.index');
        }

        $fotoBarang = Barang::whereId($barang)->first();
        if ($fotoBarang->gambar) {
            unlink(storage_path('app/public/barang/' . $fotoBarang->gambar));
        }
        Peminjaman::where('barang_id', $barang)->delete();
        Inventaris::where('barang_id', $barang)->delete();
        $barang = Barang::whereid($barang)->delete();
        if ($barang) {
            return redirect()->route('barang.index')->with('success', 'Barang Berhasil dihapus!.');
        } else {
            return redirect()->route('barang.index')->with('error', 'Barang Gagal dihapus!.');
        }
    }

    public function cart()
    {
        $user_id = Auth::user()->id;
        $peminjaman = Peminjaman::with('barang')
            ->where('user_id',  $user_id)
            ->Where('status', '<=', 3)
            ->paginate(5);
        return view('frontend.cart', compact('peminjaman'));
        // dd($peminjaman);
    }

    public function qrcode($data)
    {
        if (Auth::user()->role_id == 2) {
            $kategori = $data;
            if ($data == 1) {
                $name = 'Laboratorium Sistem Tertanam dan Robotika';
            } elseif ($data == 2) {
                $name = 'Laboratorium Rekayasa Perangkat Lunak';
            } elseif ($data == 3) {
                $name = 'Laboratorium Jaringan dan Keamanan Komputer';
            } elseif ($data == 4) {
                $name = 'Laboratorium Multimedia';
            }
        }

        if (Auth::user()->role_id == 3) {
            $kategori = 1;
            $name = 'Laboratorium Sistem Tertanam dan Robotika';
        } elseif (Auth::user()->role_id == 4) {
            $kategori = 2;
            $name = 'Laboratorium Rekayasa Perangkat Lunak';
        } elseif (Auth::user()->role_id == 5) {
            $kategori = 3;
            $name = 'Laboratorium Jaringan dan Keamanan Komputer';
        } elseif (Auth::user()->role_id == 6) {
            $kategori = 4;
            $name = 'Laboratorium Multimedia';
        }
        $barang = Barang::where('kategori', $kategori)->get();
        $pdf = PDF::loadview('backend.barang.qrcode', compact('barang'));
        return $pdf->download("Qr-Code_barang" . "-" . $name . '.pdf');
    }

    public function export($data)
    {
        if (Auth::user()->role_id == 2) {
            if (Auth::user()->role_id == 2) {
                if ($data == 1) {
                    $name = 'Laboratorium Sistem Tertanam dan Robotika';
                } elseif ($data == 2) {
                    $name = 'Laboratorium Rekayasa Perangkat Lunak';
                } elseif ($data == 3) {
                    $name = 'Laboratorium Jaringan dan Keamanan Komputer';
                } elseif ($data == 4) {
                    $name = 'Laboratorium Multimedia';
                }
            }
        }

        if (Auth::user()->role_id == 3) {
            $name = "Laboratorium Sistem Tertanam dan Robotika";
        } elseif (Auth::user()->role_id == 4) {
            $name = "Laboratorium Rekayasa Perangkat Lunak";
        } elseif (Auth::user()->role_id == 5) {
            $name = "Laboratorium Jaringan dan Keamanan Komputer";
        } elseif (Auth::user()->role_id == 6) {
            $name = "Laboratorium Multimedia";
        }
        return Excel::download(new BarangExport($data), 'Data Barang' . '-' . $name . date('Y-m-d') . '.xlsx');
    }

    public function import()
    {
        $this->validate(request(), [
            'file' => 'mimes:csv,xls,xlsx'
        ]);
        if (Auth::user()->role_id == 3) {
            $name = "Laboratorium Sistem Tertanam dan Robotika";
        } elseif (Auth::user()->role_id == 4) {
            $name = "Laboratorium Rekayasa Perangkat Lunak";
        } elseif (Auth::user()->role_id == 5) {
            $name = "Laboratorium Jaringan dan Keamanan Komputer";
        } elseif (Auth::user()->role_id == 6) {
            $name = "Laboratorium Multimedia";
        }

        if (request()->file('file') == null) {
            return redirect()->back()->with('info', 'Masukkan file terlebih dahulu!.');
        }
        $fileName = date('Y-m-d') . '_' . 'Import Barang' . '_' . $name;
        request()->file('file')->storeAs('reports', $fileName, 'public');
        Excel::import(new BarangImport, request()->file('file'));
        return redirect()->back()->with('success', 'Barang berhasil ditambah!.');
    }
}
