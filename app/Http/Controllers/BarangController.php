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
use App\Exports\DamagedExport;
use App\Imports\BarangImport;
use App\Models\Kategori;
use App\Models\Pengadaan;
use App\Models\Satuan;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\Auth\Guard;


class BarangController extends Controller
{
    protected $lab;
    protected $kode;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // $this->lab = Auth::user()->role_id;
            if (Auth::user()->role_id == 3) {
                $this->lab = 1;
                $this->kode = "EM-";
            } elseif (Auth::user()->role_id == 4) {
                $this->lab = 2;
                $this->kode = "RL-";
            } elseif (Auth::user()->role_id == 5) {
                $this->lab = 3;
                $this->kode = "JK-";
            } elseif (Auth::user()->role_id == 6) {
                $this->lab = 4;
                $this->kode = "MD-";
            }
            return $next($request);
        });
    }

    public function index()
    {

        if (Auth::user()->role_id == 2) {
            $barang = Barang::select('kategori_lab', DB::raw('count(*) as total'))
                ->groupBy('kategori_lab')
                ->get();
        } else {
            $barang = Barang::with('satuan', 'kategori')
                ->where('kategori_lab', $this->lab)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        return view('backend.barang.index', ['barang' => $barang]);
    }

    public function adminBarang($data)
    {
        $barang = Barang::with('satuan', 'kategori')
            ->where('kategori_lab', $data)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('backend.barang.admin-detail', ['barang' => $barang]);
    }

    public function create()
    {
        $kategori = Kategori::where('kategori_lab', $this->lab)->get();
        $satuan = Satuan::where('kategori_lab', $this->lab)->get();
        $pengadaan = Pengadaan::all();
        return view('backend.barang.add', compact('kategori', 'satuan', 'pengadaan'));
    }

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
            'pengadaan_id'    => 'required',
        ], [
            'required' => ':attribute wajib diisi',
        ]);

        $id_barang = Barang::max('id');
        $date = Date('ymd');
        $id = $id_barang + 1;
        if ($request->gambar) {
            $gambar = $request->gambar;
            $new_gambar = date('Y-m-d') . "-" . $request->nama . "-" . $request->tipe . "." . $gambar->getClientOriginalExtension();
            // $destination = storage_path('app/public/barang');
            $destination = 'images/barang/';
            $gambar->move($destination, $new_gambar);
            $barang = Barang::create([
                'id'            => $id,
                'kode_barang'   => $this->kode . $id . $date,
                'nama'          => $request->nama,
                'stock'         => $request->stock,
                'tipe'          => $request->tipe,
                'tgl_masuk'     => $request->tgl_masuk,
                'show'          => 0,
                'lokasi'        => $request->lokasi,
                'kategori_lab'  => $this->lab,
                'satuan_id'     => $request->satuan_id,
                'kategori_id'   => $request->kategori_id,
                'pengadaan_id'  => $request->pengadaan_id,
                'info'          => $request->info,
                'gambar'        => $new_gambar,
            ]);
        } else {
            // Barang
            $barang = Barang::create([
                'id'            => $id,
                'kode_barang'   => $this->kode . $id . $date,
                'nama'          => $request->nama,
                'stock'         => $request->stock,
                'tipe'          => $request->tipe,
                'satuan_id'     => $request->satuan_id,
                'kategori_id'   => $request->kategori_id,
                'tgl_masuk'     => $request->tgl_masuk,
                'show'          => 0,
                'lokasi'        => $request->lokasi,
                'kategori_lab'  => $this->lab,
                'pengadaan_id'  => $request->pengadaan_id,
                'info'          => $request->info,
            ]);
        }

        // Mutasi
        $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
        Inventaris::create([
            'barang_id'         => $id,
            'status'            => 1,
            'deskripsi'         => 'Baru',
            'kode_mutasi'       => 'IN' . $random,
            'kode_inventaris'   => 'IN' . $random,
            'masuk'             => $request->stock,
            'kategori_lab'      => $this->lab,
            'keluar'            => 0,
            'total'             => $request->stock,
            'stok'              => 0
        ]);

        // Inventaris
        if (strlen($id) == 1) {
            $kode = "000" . $id;
        } else if (strlen($id) == 2) {
            $kode = "00" . $id;
        } else if (strlen($id) == 3) {
            $kode = "0" . $id;
        } else {
            $kode = $id;
        }
        $Date = date("Y/m/d");
        $year = date('Y', strtotime($Date));
        $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
        $Inventaris = Inventaris::create([
            'barang_id'         => $id,
            'status'            => 2,
            'deskripsi'         => 'Created',
            'kode_mutasi'       => 'Kosong',
            'kode_inventaris'   => $kode . '.' . $id . '.' . $id_barang . '.' . $year,
            'masuk'             => 0,
            'kategori_lab'      => $this->lab,
            'keluar'            => 0,
            'total'             => 0,
            'stok'              => $request->stock
        ]);

        if ($Inventaris) {
            return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambah');
        } else {
            return redirect()->route('barang.index')->with('error', 'Barang gagal ditambah');
        }
    }

    public function show(Barang $barang)
    {
        return view('backend.barang.detail', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $kategori = Kategori::where('kategori_lab', $this->lab)->get();
        $satuan = Satuan::where('kategori_lab', $this->lab)->get();
        $pengadaan = Pengadaan::all();
        return view('backend.barang.edit', compact('barang', 'satuan', 'kategori', 'pengadaan'));
    }

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
                'pengadaan_id'  => $request->pengadaan_id,
                'info'          => $request->info,
                'gambar'        => $new_gambar,
            ]);
        } else {
            $barang_update = Barang::whereid($barang->id)->update([
                'nama'          => $request->nama,
                'stock'         => $request->stock,
                'tipe'          => $request->tipe,
                'satuan_id'     => $request->satuan_id,
                'kategori_id'   => $request->kategori_id,
                'tgl_masuk'     => $request->tgl_masuk,
                'show'          => $request->show,
                'lokasi'        => $request->lokasi,
                'pengadaan_id'  => $request->pengadaan_id,
                'info'          => $request->info,

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
                ->get();
            // dd($barang);
            return view('backend.barang.rusak.damaged', compact('barang'));
        } else {
            $barang = Barang::whereNotNull('jml_rusak')
                ->where('kategori_lab', $this->lab)
                ->where('jml_rusak', '>', 0)
                ->orderBy('updated_at', 'Desc')
                ->get();
            return view('backend.barang.rusak.damaged', compact('barang'));
        }
    }

    public function adminDamaged($data)
    {
        $barang = Barang::whereNotNull('jml_rusak')->where('kategori_lab', $data)->get();
        return view('backend.barang.rusak.admin-damaged', compact('barang'));
    }

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
        ], [
            'required' => ':attribute Format file tidak terbaca',
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


    public function createDamaged()
    {
        $barang = Barang::where('kategori_lab', $this->lab)->get();
        return view('backend.barang.rusak.damaged-add', compact('barang'));
    }

    public function storeDamaged(Request $request)
    {
        $request->validate([
            'jumlah'    => 'required',
        ], [
            'required' => ':attribute wajib diisi',
        ]);

        $id_barang = $request->barang;
        $stok = $request->total_stok;
        $rsk = $request->total_rusak;
        $jml = $request->jumlah;
        if ($request->keterangan == null) {
            $ket = '-';
        } else {
            $ket = $request->keterangan;
        }

        $cekInventaris = Inventaris::where('barang_id', $id_barang)->where('kode_mutasi', "kosong")->get();
        if ($cekInventaris->IsNotEmpty()) {
            Barang::whereId($id_barang)->update(['stock' => $stok - $jml, 'jml_rusak' => $rsk + $jml, 'keterangan_rusak' => $ket]);

            // ineventaris update
            $kodeInventaris = Inventaris::where('kode_mutasi', "kosong")->where('barang_id', $id_barang)->value('kode_inventaris');
            $stokInventaris = Inventaris::where('kode_mutasi', "kosong")->where('barang_id', $id_barang)->value('stok');
            Inventaris::where('kode_inventaris', $kodeInventaris)->update([
                'stok'            => $stokInventaris - $jml,
            ]);

            // mutasi
            $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            $mutasi = Inventaris::create([
                'barang_id'         => $id_barang,
                'status'            => 0,
                'deskripsi'         => 'Rusak',
                'kode_inventaris'   => 'OUT' . $random,
                'kode_mutasi'       => 'OUT' . $random,
                'masuk'             => 0,
                'kategori_lab'      => $this->lab,
                'keluar'            => $jml,
                'total'             => $stokInventaris - $jml,
                'stok'              => 0,
            ]);

            if ($mutasi) {
                return redirect()->route('barang.damaged')->with('success', 'Stok Barang Berhasil dibaharui!.');
            } else {
                return redirect()->route('barang.damaged')->with('error', 'Stok Barang Gagal dibaharui!.');
            }
        } else {
            return redirect()->route('barang.damaged')->with('warning', 'Data Inventaris Belum didaftarkan!.');
        }
    }

    public function showStok()
    {
        $barang = Barang::where('kategori_lab', $this->lab)->get();
        return view('backend.barang.stok-update', compact('barang'));
    }

    public function updateStok(Request $request)
    {
        $request->validate([
            'jumlah'    => 'required',
        ], [
            'required' => ':attribute wajib diisi',
        ]);

        $id_barang = $request->barang;
        $stok = $request->total_stok;
        $jml = $request->jumlah;
        $cekInventaris = Inventaris::where('barang_id', $id_barang)->where('kode_mutasi', "kosong")->get();
        if ($cekInventaris->IsNotEmpty()) {
            Barang::whereId($id_barang)->update(['stock' => $stok + $jml]);

            // ineventaris
            $kodeInventaris = Inventaris::where('kode_mutasi', "kosong")->where('barang_id', $id_barang)->value('kode_inventaris');
            $stokInventaris = Inventaris::where('kode_mutasi', "kosong")->where('barang_id', $id_barang)->value('stok');
            Inventaris::where('kode_inventaris', $kodeInventaris)->update([
                'stok'            => $stokInventaris + $jml,
            ]);

            // mutasi
            $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            $mutasi = Inventaris::create([
                'barang_id'         => $id_barang,
                'status'            => 1,
                'deskripsi'         => 'Update',
                'kode_inventaris'   => 'IN' . $random,
                'kode_mutasi'       => 'IN' . $random,
                'masuk'             => $jml,
                'kategori_lab'      => $this->lab,
                'keluar'            => 0,
                'total'             => $stokInventaris + $jml,
                'stok'              => 0,
            ]);

            if ($mutasi) {
                return redirect()->route('barang.index')->with('success', 'Stok Barang Berhasil ditambahi!.');
            } else {
                return redirect()->route('barang.index')->with('error', 'Stok Barang Gagal ditambahi!.');
            }
        } else {
            return redirect()->route('barang.index')->with('warning', 'Data Inventaris Belum didaftarkan!.');
        }
    }

    public function damagedExport($data)
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
        return Excel::download(new DamagedExport($data), 'Data Barang Rusak' . '-' . $name . date('Y-m-d') . '.xlsx');
    }

    public function damagedPdf($data)
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
        $barang = Barang::where('kategori_lab', $kategori_lab)->whereNotNull('jml_rusak')->get();
        // return view('backend.inventaris.pdf_inventaris', compact('name', 'inventaris'));
        $pdf = Pdf::loadview('backend.barang.rusak.pdf_damaged', compact('name', 'barang'));

        return $pdf->download("Data Barang Rusak" . "_" . $name . '_' . date('d-m-Y') . '.pdf');
    }

    public function barangDipinjam()
    {
        $barang = Peminjaman::where('kategori_lab', $this->lab)->groupBy('barang_id')->select('barang_id')->get();
        return view('backend.barang.barang-dipinjam', compact('barang'));
    }

    public function dipinjamAjax(Request $request)
    {
        $kode = $request->select;
        $head =
            '<tr>' .
            '<th width="5%">No</th>' .
            '<th width="20%">Peminjam</th>' .
            '<th width="15%">Tanggal Pinjam</th>' .
            '<th width="15%">Tanggal Pengembalian</th>' .
            '<th width="10%">Jumlah</th>' .
            '</tr>';
        $body = "";
        $nama = "";
        $peminjaman = Peminjaman::where('barang_id', $kode)->where('kategori_lab', $this->lab)->get();
        foreach ($peminjaman as $key => $data) {
            $nama = "Daftar Peminjam" . "<br>" . $data->barang->nama . " " . "-" . " " . $data->barang->tipe;
            $key = $key + 1;
            $body .= '<tr>' .
                '<td>' . $key . '</td>' .
                '<td>' . $data->user->name . '</td>' .
                '<td>' . $data->tgl_start . '</td>' .
                '<td>' . $data->tgl_end . '</td>' .
                '<td>' . $data->jumlah . " " . $data->barang->satuan->nama_satuan . '</td>' .
                '</tr>';
        }
        return response()->json([
            'head' => $head,
            'body' => $body,
            'nama' => $nama
        ]);
    }
}
