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
use App\Models\Kategori;
use App\Models\Satuan;
use App\Models\User;
use Facade\FlareClient\Stacktrace\File;
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
            $kategori_lab = 1;
        } elseif (Auth::user()->role_id == 4) {
            $kategori_lab = 2;
        } elseif (Auth::user()->role_id == 5) {
            $kategori_lab = 3;
        } elseif (Auth::user()->role_id == 6) {
            $kategori_lab = 4;
        }

        if (Auth::user()->role_id == 2) {
            $barang = Barang::select('kategori_lab', DB::raw('count(*) as total'))
                ->groupBy('kategori_lab')
                ->paginate(5);
        } else {
            $barang = Barang::with('satuan', 'kategori')
                ->where('kategori_lab', $kategori_lab)
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }
        return view('backend.barang.index', ['barang' => $barang]);
    }

    public function adminBarang($data)
    {
        $barang = Barang::with('satuan', 'kategori')
            ->where('kategori_lab', $data)
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
        if (Auth::user()->role_id == 3) {
            $kategori_lab = 1;
        } elseif (Auth::user()->role_id == 4) {
            $kategori_lab = 2;
        } elseif (Auth::user()->role_id == 5) {
            $kategori_lab = 3;
        } elseif (Auth::user()->role_id == 6) {
            $kategori_lab = 4;
        }
        $kategori = Kategori::where('kategori_lab', $kategori_lab)->get();
        $satuan = Satuan::where('kategori_lab', $kategori_lab)->get();
        return view('backend.barang.add', compact('kategori', 'satuan'));
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
            'satuan_id'    => 'required',
            'kategori_id'    => 'required',
            'stock'     => 'required|int',
            'tipe'      => 'required',
            'tgl_masuk' => 'required',
            'show'      => 'required|in:0,1',
            'lokasi'    => 'required',
        ], [
            'required' => ':attribute wajib diisi',
        ]);

        if (Auth::user()->role_id == 3) {
            $kategori_lab = 1;
            $kode = "EM-";
        } elseif (Auth::user()->role_id == 4) {
            $kategori_lab = 2;
            $kode = "RL-";
        } elseif (Auth::user()->role_id == 5) {
            $kategori_lab = 3;
            $kode = "JK-";
        } elseif (Auth::user()->role_id == 6) {
            $kategori_lab = 4;
            $kode = "MD-";
        }

        $id_barang = Barang::max('id');
        $date = Date('ymd');

        if ($request->gambar) {
            $gambar = $request->gambar;
            $new_gambar = date('Y-m-d') . "-" . $request->nama . "-" . $request->tipe . "." . $gambar->getClientOriginalExtension();
            // $destination = storage_path('app/public/barang');
            $destination = 'images/barang/';
            $gambar->move($destination, $new_gambar);
            $barang = Barang::create([
                'kode_barang'   => $kode . $id_barang . $date,
                'nama'          => $request->nama,
                'stock'         => $request->stock,
                'tipe'          => $request->tipe,
                'tgl_masuk'     => $request->tgl_masuk,
                'show'          => $request->show,
                'lokasi'        => $request->lokasi,
                'kategori_lab'  => $kategori_lab,
                'satuan_id'     => $request->satuan_id,
                'kategori_id'   => $request->kategori_id,
                'info'          => $request->info,
                'gambar'        => $new_gambar,
            ]);

            // Inventaris
            $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            Inventaris::create([
                'barang_id'         => $id_barang + 1,
                'status'            => 1,
                'deskripsi'         => 'New',
                'kode_mutasi'       => 'IN' . $random,
                'kode_inventaris'   => 'IN' . $random,
                'masuk'             => $request->stock,
                'kategori_lab'      => $kategori_lab,
                'keluar'            => 0,
                'total'             => $request->stock,
            ]);
        } else {
            // Barang
            $barang = Barang::create([
                'kode_barang'   => $kode . $id_barang . $date,
                'nama'          => $request->nama,
                'stock'         => $request->stock,
                'tipe'          => $request->tipe,
                'satuan_id'     => $request->satuan_id,
                'kategori_id'   => $request->kategori_id,
                'tgl_masuk'     => $request->tgl_masuk,
                'show'          => $request->show,
                'lokasi'        => $request->lokasi,
                'kategori_lab'  => $kategori_lab,
                'info'          => $request->info,
            ]);

            // Inventaris
            $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            Inventaris::create([
                'barang_id'         => $id_barang + 1,
                'status'            => 1,
                'deskripsi'         => 'New',
                'kode_inventaris'   => 'IN' . $random,
                'kode_mutasi'       => 'IN' . $random,
                'masuk'             => $request->stock,
                'kategori_lab'      => $kategori_lab,
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
        $satuan = Satuan::all();
        $kategori = Kategori::all();
        return view('backend.barang.edit', compact('barang', 'satuan', 'kategori'));
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
            'nama'              => 'required',
            'stock'             => 'required|int',
            'tipe'              => 'required',
            'tgl_masuk'         => 'required',
            'show'              => 'required|in:0,1',
            'lokasi'            => 'required',
        ], [
            'required' => ':attribute Bagian ini wajib diisi',
        ]);
        if ($request->gambar) {
            $bb = Barang::whereid($barang->id)->first();
            if (file_exists(public_path('/images/barang/' . $bb->gambar))) {
                unlink('images/barang/' . $bb->gambar);
            }
            $gambar = $request->gambar;
            $new_gambar = date('Y-m-d') . "-" . $request->nama . "-" . $request->tipe . "." . $gambar->getClientOriginalExtension();
            $destination = 'images/barang/';
            $gambar->move($destination, $new_gambar);
            $barang_update = Barang::whereid($barang->id)->update([
                'nama'          => $request->nama,
                'stock'         => $request->stock,
                'tipe'          => $request->tipe,
                'tgl_masuk'     => $request->tgl_masuk,
                'show'          => $request->show,
                'lokasi'        => $request->lokasi,
                'satuan_id'     => $request->satuan_id,
                'kategori_id'   => $request->kategori_id,
                'info'          => $request->info,
                'gambar'        => $new_gambar,
            ]);
        } else {
            $barang_update = Barang::whereid($barang->id)->update([
                'nama'          => $request->nama,
                'stock'         => $request->stock,
                'tipe'          => $request->tipe,
                'satuan_id'        => $request->satuan_id,
                'kategori_id'        => $request->kategori_id,
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
                ->select('kategori_lab', DB::raw('count(*) as total'))
                // ->selectRaw(DB::raw("SUM(jml_rusak) as total"))
                ->groupBy('kategori_lab')
                ->paginate(5);
            // dd($barang);
            return view('backend.barang.damaged', compact('barang'));
        } else {
            if (Auth::user()->role_id == 3) {
                $kategori_lab = 1;
            } elseif (Auth::user()->role_id == 4) {
                $kategori_lab = 2;
            } elseif (Auth::user()->role_id == 5) {
                $kategori_lab = 3;
            } elseif (Auth::user()->role_id == 6) {
                $kategori_lab = 4;
            }
            $barang = Barang::whereNotNull('jml_rusak')->where('kategori_lab', $kategori_lab)->paginate(5);
            return view('backend.barang.damaged', compact('barang'));
        }
    }

    public function adminDamaged($data)
    {
        $barang = Barang::whereNotNull('jml_rusak')->where('kategori_lab', $data)->paginate(5);
        return view('backend.barang.admin-damaged', compact('barang'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang, Request $request)
    {
        $barang_id = $request->delete_id;
        $peminjaman = Peminjaman::where('barang_id', $barang_id)->where('status', '<', 4)->get();
        if ($peminjaman->isNotEmpty()) {
            request()->session()->flash('active', "Barang gagal dihapus, Masih terdapat transaksi peminjaman");
            return redirect()->route('barang.index');
        }

        $fotoBarang = Barang::whereId($barang_id)->first();
        if ($fotoBarang->gambar) {
            if (file_exists(public_path('/images/barang/' . $fotoBarang->gambar))) {
                unlink('images/barang/' . $fotoBarang->gambar);
            }
        }
        Peminjaman::where('barang_id', $barang_id)->delete();
        Inventaris::where('barang_id', $barang_id)->delete();
        $delete = Barang::whereId($barang_id)->delete();
        if ($delete) {
            return redirect()->route('barang.index')->with('success', 'Barang Berhasil dihapus!.');
        } else {
            return redirect()->route('barang.index')->with('error', 'Barang Gagal dihapus!.');
        }
    }



    public function qrcode($data)
    {
        if (Auth::user()->role_id == 2) {
            $kategori_lab = $data;
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
            $kategori_lab = 1;
            $name = 'Laboratorium Sistem Tertanam dan Robotika';
        } elseif (Auth::user()->role_id == 4) {
            $kategori_lab = 2;
            $name = 'Laboratorium Rekayasa Perangkat Lunak';
        } elseif (Auth::user()->role_id == 5) {
            $kategori_lab = 3;
            $name = 'Laboratorium Jaringan dan Keamanan Komputer';
        } elseif (Auth::user()->role_id == 6) {
            $kategori_lab = 4;
            $name = 'Laboratorium Multimedia';
        }
        $barang = Barang::where('kategori_lab', $kategori_lab)->get();
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

    public function barangPdf($data)
    {
        if (Auth::user()->role_id == 2) {
            if (Auth::user()->role_id == 2) {
                if ($data == 1) {
                    $name = 'Laboratorium Sistem Tertanam dan Robotika';
                    $kategori_lab = 1;
                } elseif ($data == 2) {
                    $name = 'Laboratorium Rekayasa Perangkat Lunak';
                    $kategori_lab = 2;
                } elseif ($data == 3) {
                    $name = 'Laboratorium Jaringan dan Keamanan Komputer';
                    $kategori_lab = 3;
                } elseif ($data == 4) {
                    $name = 'Laboratorium Multimedia';
                    $kategori_lab = 4;
                }
            }
        }

        if (Auth::user()->role_id == 3) {
            $name = "Laboratorium Sistem Tertanam dan Robotika";
            $kategori_lab = 1;
        } elseif (Auth::user()->role_id == 4) {
            $name = "Laboratorium Rekayasa Perangkat Lunak";
            $kategori_lab = 2;
        } elseif (Auth::user()->role_id == 5) {
            $name = "Laboratorium Jaringan dan Keamanan Komputer";
            $kategori_lab = 3;
        } elseif (Auth::user()->role_id == 6) {
            $name = "Laboratorium Multimedia";
            $kategori_lab = 4;
        }
        $barang = Barang::where('kategori_lab', $kategori_lab)->get();
        // return view('backend.inventaris.pdf_inventaris', compact('name', 'inventaris'));
        $pdf = Pdf::loadview('backend.barang.pdf_barang', compact('name', 'barang'));

        return $pdf->download("Data Barang" . "_" . $name . '_' . date('d-m-Y') . '.pdf');
    }
}
