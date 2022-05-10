<?php

namespace App\Http\Controllers;

use App\Exports\PeminjamanExport;
use App\Models\Barang;
use App\Models\Keranjang;
use App\Models\Peminjaman;
use App\Models\Inventaris;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;

class PeminjamanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('role:operator|peminjam');
    }

    // Peminjaman
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
            $peminjaman = Peminjaman::with('user', 'barang')
                ->where('status', '>', 2)
                ->select('kategori_lab', DB::raw('count(*) as total'))
                ->groupBy('kategori_lab')
                ->paginate(5);
        } else {
            if (request()->start_date || request()->end_date) {
                $start_date = Carbon::parse(request()->start_date)->format('Y-m-d');
                $end_date = Carbon::parse(request()->end_date)->format('Y-m-d');
                $peminjaman = Peminjaman::with('user', 'barang')
                    ->where('kategori_lab', $kategori_lab)
                    ->where('status', '>=', 2)
                    ->whereBetween('date', [$start_date, $end_date])
                    ->paginate(5);
            } else {
                $peminjaman = Peminjaman::with('user', 'barang')
                    ->where('kategori_lab', $kategori_lab)
                    ->where('status', '>=', 2)
                    ->paginate(5);
            }
        }
        return view('backend.transaksi.index', compact('peminjaman'));
    }

    public function show($data)
    {
        $peminjaman = Peminjaman::with('user', 'barang')->whereId($data)->first();
        return view('backend.transaksi.show', compact('peminjaman'));
    }

    public function adminPeminjaman($data)
    {
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->format('Y-m-d');
            $end_date = Carbon::parse(request()->end_date)->format('Y-m-d');
            $peminjaman = Peminjaman::with('user', 'barang')
                ->where('kategori_lab', $data)
                ->where('status', '>', 2)
                ->whereBetween('date', [$start_date, $end_date])
                ->paginate(5);
        } else {
            $peminjaman = Peminjaman::with('user', 'barang')
                ->where('kategori_lab', $data)
                ->where('status', '>', 2)
                ->paginate(5);
        }
        return view('backend.transaksi.admin-peminjaman', compact('peminjaman'));
    }

    // Konfirmasi Peminjaman
    public function pengajuan()
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
        $peminjaman = Peminjaman::withCount('user')
            ->select('date', DB::raw('count(*) as total'))
            ->where('kategori_lab', $kategori_lab)
            ->where('status', 0)
            ->groupBy('date')
            ->paginate(5);
        return view('backend.transaksi.konfirmasi.pengajuan', compact('peminjaman'));
    }

    public function pengajuanDetail($data)
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
        $peminjaman = Peminjaman::with('user', 'barang')
            ->where('kategori_lab', $kategori_lab)
            ->where('date', $data)
            ->Where('status', 0)
            ->paginate(5);
        return view('backend.transaksi.konfirmasi.pengajuan-detail', compact('peminjaman'));
    }

    // Konfirmasi Peminjaman
    public function peminjaman()
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
        $peminjaman = Peminjaman::withCount('user')
            ->select('date', DB::raw('count(*) as total'))
            ->where('kategori_lab', $kategori_lab)
            ->where('status', 2)
            ->orwhere('status', 3)
            ->groupBy('date')
            ->paginate(5);
        return view('backend.transaksi.konfirmasi.peminjaman.index', compact('peminjaman'));
    }

    public function konfirmasiPeminjamanDetail($data)
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
        $peminjaman = Peminjaman::with('user', 'barang')
            ->where('date', $data)
            ->where('kategori_lab', $kategori_lab)
            ->where('status', 2)
            ->orwhere('status', 3)
            ->paginate(5);
        return view('backend.transaksi.konfirmasi.peminjaman.detail', compact('peminjaman'));
    }

    public function create()
    {
        $barang = Barang::all();
        $user = User::where('role_id', 3)->get();
        return view('backend.transaksi.konfirmasi.peminjaman.add', compact('barang', 'user'));
    }

    public function store(Request $request, $id)
    {
        $max = Peminjaman::where('user_id', Auth::user()->id)->where('status', '!=', 4)->count();
        $id_cart = $request->ckd_chld;
        $count = count($id_cart);
        $total = $max + $count;
        if ($max >= 4 || $count > 4 || $total > 4) {
            return redirect()->back()->with('max', 'Anda hanya dapat melakukan peminjaman sebanyak 4 barang...!!');
        } else {
            $peminjaman = Keranjang::whereIn('id', $id_cart)->get();
            foreach ($peminjaman as $data) {
                $peminjaman = Peminjaman::create([
                    'id'            => substr(str_shuffle("0123456789"), 0, 8),
                    'user_id'       => $id,
                    'barang_id'     => $data->barang_id,
                    'tgl_start'     => $data->tgl_start,
                    'tgl_end'       => $data->tgl_end,
                    'jumlah'        => $data->jumlah,
                    'kategori_lab'  => $data->kategori_lab,
                    'alasan'        => $data->alasan,
                    'status'        => 0,
                    'date'          => date('Y-m-d')
                ]);
            }

            foreach ($id_cart as $id) {
                Keranjang::where('id', $id)->update(['status' => 1]);
            }

            if ($peminjaman) {
                return redirect()->route('daftar.pinjaman')->with('success', 'Pengajuan Berhasil ditambah!.');
            } else {
                return redirect()->route('daftar.pinjaman')->with('error', 'Gagal ditambah!.');
            }
        }
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::with('barang')->whereId($id)->first();
        return view('frontend.edit-detail', compact('peminjaman'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required',
            'alasan' => 'required',
            'tgl_start' => 'required',
            'tgl_end' => 'required',
        ]);
        $peminjaman = Peminjaman::whereId($id)->update([
            'tgl_start' => $request->tgl_start,
            'tgl_end'   => $request->tgl_end,
            'jumlah'    => $request->jumlah,
            'alasan'    => $request->alasan,
        ]);
        if ($peminjaman) {
            return redirect()->route('daftar.pinjaman')->with('success', 'Barang Berhasil di edit!.');
        } else {
            return redirect()->back()->with('error', 'Gagal ditambah');
        }
    }

    public function destroy($id, Request $request)
    {
        $pem = $request->delete_id;
        $jml = $request->brg_jml;
        $stok = $request->brg_stok;
        $barang_id = Peminjaman::where('id', $pem)->value('barang_id');
        $user_id = Peminjaman::where('id', $pem)->value('user_id');
        if ($jml || $stok) {
            Barang::whereId($barang_id)->update(['stock' => $stok + $jml]);
        }
        Keranjang::where('user_id', $user_id)->where('barang_id', $barang_id)->delete();
        $peminjaman = Peminjaman::where('id', $pem)->delete();
        if ($peminjaman) {
            return redirect()->back()->with('success', 'Barang Berhasil dihapus!.');
        } else {
            return redirect()->back()->with('error', 'Barang Gagal dihapus!.');
        }
    }


    public function konfirmasiStatus($id_peminjaman, $status, $barang_id, $jumlah, $user_id)
    {
        if ($status == 3) {
            // $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            // $sisa = Barang::where('id', $barang_id)->first();
            // $total = $sisa->stock;
            // $kategori_lab = $sisa->kategori_lab;
            // if ($total - $jumlah < 0) {
            //     return redirect()->back()->with('warning', 'Inventaris Barang tidak mencukupi!.');
            // }
            // $telat = Peminjaman::whereid($id_peminjaman)->first();
            // if ($telat->tgl_end < date('Y-m-d')) {
            //     return redirect()->back()->with('warning', 'Konfirmasi peminjaman telat!.');
            // }
            // $inventaris = Inventaris::create([
            //     'barang_id'         => $barang_id,
            //     'status'            => 0,
            //     'deskripsi'         => "Active",
            //     'kode_mutasi'   => 'OUT' . $random,
            //     'kode_inventaris'   => 0,
            //     'masuk'             => 0,
            //     'keluar'            => $jumlah,
            //     'kategori_lab'      => $kategori_lab,
            //     'total'             => $total - $jumlah,
            // ]);
            // Barang::whereid($barang_id)->update(['stock' => $total - $jumlah]);
            // Peminjaman::whereId($id_peminjaman)->update(['status' => $status]);
            // if ($inventaris) {
            //     return redirect()->back()->with('success', 'Peminjaman Berhasil di Setujui!.');
            // }
        } elseif ($status == 4) {
            $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            $sisa = Barang::where('id', $barang_id)->first();
            $total = $sisa->stock;
            $kategori_lab = $sisa->kategori_lab;
            // Mutasi
            $inventaris = Inventaris::create([
                'barang_id'         => $barang_id,
                'status'            => 1,
                'deskripsi'         => "Selesai",
                'kode_mutasi'       => 'IN' . $random,
                'kode_inventaris'   => 'IN' . $random,
                'masuk'             => $jumlah,
                'keluar'            => 0,
                'kategori_lab'      => $kategori_lab,
                'total'             => $total + $jumlah,
                'stok'              => 0
            ]);
            Barang::whereId($barang_id)->update(['stock' => $total + $jumlah]);
            Peminjaman::whereId($id_peminjaman)->update(['status' => $status]);
            Keranjang::where('user_id', $user_id)->where('barang_id', $barang_id)->delete();
            if ($inventaris) {
                return redirect()->back()->with('success', 'Pengembalian Berhasil di Setujui!.');
            }
        } elseif ($status == 2) {
            $sisa = Barang::where('id', $barang_id)->first();
            $kategori_lab = $sisa->kategori_lab;
            $total = $sisa->stock;
            if ($total - $jumlah < 0) {
                return redirect()->back()->with('warning', 'Inventaris Barang tidak mencukupi!.');
            }
            $telat = Peminjaman::whereid($id_peminjaman)->first();
            if ($telat->tgl_end < date('Y-m-d')) {
                return redirect()->back()->with('warning', 'Konfirmasi pengajuan telat!.');
            }
            $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            // Mutasi
            $inventaris = Inventaris::create([
                'barang_id'         => $barang_id,
                'status'            => 0,
                'deskripsi'         => "Pinjam",
                'kode_mutasi'       => 'OUT' . $random,
                'kode_inventaris'   => 'OUT' . $random,
                'masuk'             => 0,
                'keluar'            => $jumlah,
                'kategori_lab'      => $kategori_lab,
                'total'             => $total - $jumlah,
                'stok'              => 0
            ]);
            Barang::whereid($barang_id)->update(['stock' => $total - $jumlah]);
            Peminjaman::whereId($id_peminjaman)->update(['status' => $status]);
            if ($inventaris) {
                return redirect()->back()->with('success', 'Peminjaman Berhasil di Setujui!.');
            }
        }
    }

    public function tolak(Request $request)
    {
        $id_peminjaman = $request->peminjaman_id;
        $pesan = $request->pesan;
        if ($pesan == null) {
            $pesan = "Stock Tidak Cukup";
        }
        $peminjaman = Peminjaman::whereId($id_peminjaman)->update(['status' => 1, 'pesan' => $pesan]);
        if ($peminjaman) {
            return redirect()->back()->with('info', 'Pengajuan Berhasil di Tolak!.');
        } else {
            return redirect()->back()->with('error', 'Gagal diperbarui');
        }
    }


    // Konfirmasi Pengembalian
    // public function pengembalian()
    // {
    //     if (Auth::user()->role_id == 3) {
    //         $kategori_lab = 1;
    //     } elseif (Auth::user()->role_id == 4) {
    //         $kategori_lab = 2;
    //     } elseif (Auth::user()->role_id == 5) {
    //         $kategori_lab = 3;
    //     } elseif (Auth::user()->role_id == 6) {
    //         $kategori_lab = 4;
    //     }
    //     $peminjaman = Peminjaman::with('user', 'barang')
    //         ->where('status', 3)
    //         ->orwhere('status', 5)
    //         ->where('kategori_lab', $kategori_lab)
    //         ->paginate(5);
    //     return view('backend.transaksi.konfirmasi.pengembalian.index', compact('peminjaman'));
    // }

    public function scan($status)
    {
        if ($status == 'peminjaman') {
            return view('backend.transaksi.konfirmasi.peminjaman.scan');
        } else {
            return view('backend.transaksi.konfirmasi.pengembalian.scan');
        }
    }

    // public function scanStorde($id, $status)
    // {
    //     if (Auth::user()->role_id == 3) {
    //         $kategori_lab = 1;
    //     } elseif (Auth::user()->role_id == 4) {
    //         $kategori_lab = 2;
    //     } elseif (Auth::user()->role_id == 5) {
    //         $kategori_lab = 3;
    //     } elseif (Auth::user()->role_id == 6) {
    //         $kategori_lab = 4;
    //     }

    //     // Status 1 = peminjaman
    //     // Status 0 = Pengembalian
    //     $id_peminjaman = intval($id);
    //     $sts = intval($status);
    //     $cek = Peminjaman::whereid($id_peminjaman)->get();
    //     if ($cek->isEmpty()) {
    //         return redirect()->back()->with('info', 'Barcode barang tidak ditemukan!.');
    //     }
    //     $cekaja = Peminjaman::whereid($id_peminjaman)->first();

    //     if ($sts == 1) {
    //         // Peminjaman
    //         // dd($cekaja->status);
    //         if ($cekaja->status < 3) {
    //             $barang = Peminjaman::where('id', $id_peminjaman)->value('barang_id');
    //             $jumlah = Peminjaman::where('id', $id_peminjaman)->value('jumlah');
    //             $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
    //             $sisa = Barang::whereId(intval($barang))->value('stock');
    //             if ($sisa - $jumlah < 0) {
    //                 return redirect()->back()->with('warning', 'Inventaris Barang tidak mencukupi!.');
    //             }
    //             $telat = Peminjaman::whereid($id_peminjaman)->first();
    //             if ($telat->tgl_start < date('Y-m-d')) {
    //                 return redirect()->back()->with('warning', 'Konfirmasi peminjaman telat!.');
    //             }
    //             Inventaris::create([
    //                 'barang_id'         => intval($barang),
    //                 'kategori_lab'      => $kategori_lab,
    //                 'status'            => 0,
    //                 'deskripsi'         => "Pinjam",
    //                 'kode_mutasi'       => 'OUT' . $random,
    //                 'kode_inventaris'   => 0,
    //                 'masuk'             => 0,
    //                 'keluar'            => $jumlah,
    //                 'total'             => $sisa - $jumlah,
    //             ]);
    //             Barang::whereId($barang)->update(['stock' => $sisa - $jumlah]);
    //             Peminjaman::whereId($id_peminjaman)->update(['status' => 3]);
    //             return redirect()->back()->with('success', 'Peminjaman berhasil disetujui!.');
    //         } else if ($cekaja->status == 3) {
    //             return redirect()->back()->with('success', 'Peminjaman berhasil disetujui!.');
    //         } else if ($cekaja->status > 3) {
    //             return redirect()->back()->with('warning', 'Tidak terdaftar dalam aktivasi peminjaman!.');
    //         }
    //     } else {
    //         $barang = Peminjaman::whereid($id_peminjaman)->value('barang_id');
    //         $jumlah = Peminjaman::whereid($id_peminjaman)->value('jumlah');
    //         $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
    //         $sisa = Barang::whereId($barang)->value('stock');
    //         Inventaris::create([
    //             'barang_id'         => $barang,
    //             'kategori_lab'      => $kategori_lab,
    //             'status'            => 1,
    //             'deskripsi'         => "Selesai",
    //             'kode_mutasi'       => 'IN' . $random,
    //             'kode_inventaris'   => 'IN' . $random,
    //             'masuk'             => $jumlah,
    //             'keluar'            => 0,
    //             'total'             => $sisa + $jumlah,
    //             'stok'              => 0
    //         ]);
    //         Barang::whereId($barang)->update(['stock' => $sisa + $jumlah]);
    //         Peminjaman::whereId($id_peminjaman)->update(['status' => 4]);
    //         return redirect()->back()->with('success', 'Pengembalian berhasil disetujui!.');
    //     }
    // }

    public function scanStore($id, $status, Request $request)
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

        $id_peminjaman = intval($id);
        $cek = Peminjaman::whereid($id_peminjaman)->get();
        if ($cek->isEmpty()) {
            return redirect()->back()->with('info', 'Barcode barang tidak ditemukan!.');
        }

        $ceksts = Peminjaman::where('id', $id_peminjaman)->first();
        if ($ceksts->status == 2) {
            $barang = Peminjaman::where('id', $id_peminjaman)->value('barang_id');
            $jumlah = Peminjaman::where('id', $id_peminjaman)->value('jumlah');
            $user = Peminjaman::where('id', $id_peminjaman)->value('user_id');
            $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            $sisa = Barang::whereId($barang)->value('stock');
            Inventaris::create([
                'barang_id'         => $barang,
                'kategori_lab'      => $kategori_lab,
                'status'            => 1,
                'deskripsi'         => "Selesai",
                'kode_mutasi'       => 'IN' . $random,
                'kode_inventaris'   => 'IN' . $random,
                'masuk'             => $jumlah,
                'keluar'            => 0,
                'total'             => $sisa + $jumlah,
                'stok'              => 0
            ]);
            Peminjaman::whereId($id_peminjaman)->update(['status' => 4]);
            Barang::whereId($barang)->update(['stock' => $sisa + $jumlah]);
            Keranjang::where('user_id', $user)->where('barang_id', $barang)->delete();
            return redirect()->back()->with('success', 'Pengembalian berhasil disetujui!.');
        } else {
            return redirect()->back()->with('success', 'Pengembalian berhasil disetujui!.');
        }
    }

    public function print()
    {
        $user_id = Auth::user()->id;
        $name = Auth::user()->name;
        $nim = Auth::user()->nim;
        $alamat = Auth::user()->alamat;
        $cek = Peminjaman::where('status', 0)->get();
        if ($cek->isNotEmpty()) {
            return redirect()->back()->with('info', 'Terdapat pengajuan yang belum disetujui!.');
        }
        $peminjaman = Peminjaman::where('user_id', $user_id)->where('status', 2)->get();
        $pdf = PDF::loadview('frontend.surat-peminjaman', ['peminjaman' => $peminjaman, 'name' => $name, 'nim' => $nim, 'alamat' => $alamat]);
        // return view('frontend.surat', ['peminjaman' => $peminjaman, 'name' => $name, 'nim' => $nim, 'alamat' => $alamat]);

        return $pdf->download("Surat Peminjaman" . "_" . $name . '_' . $nim . '.pdf');
    }

    public function suratBebas()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        return view('frontend.surat', compact('user'));
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
        $peminjaman = Peminjaman::where('status', 4)->get();
        if ($peminjaman->IsNotEmpty()) {
            return Excel::download(new PeminjamanExport($data), 'Data Peminjaman' . '-' . $name . '-' . date('Y-m-d') . '.xlsx');
        } else {
            return redirect()->back()->with('info', 'Belum terdapat peminjaman selesai!.');
        }
    }

    public function updateAll(Request $request)
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
        $id_peminjaman = $request->ckd_chld;
        if ($id_peminjaman) {
            foreach ($id_peminjaman as $id) {
                $barang = Peminjaman::whereid($id)->value('barang_id');
                $jumlah = Peminjaman::whereid($id)->value('jumlah');
                $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
                $sisa = Barang::whereId($barang)->value('stock');
                Inventaris::create([
                    'barang_id'         => $barang,
                    'kategori_lab'      => $kategori_lab,
                    'status'            => 1,
                    'deskripsi'         => "Clear",
                    'kode_mutasi'       => 'IN' . $random,
                    'kode_inventaris'       => 0,
                    'masuk'             => $jumlah,
                    'keluar'            => 0,
                    'total'             => $sisa + $jumlah,
                ]);
                Barang::whereId($barang)->update(['stock' => $sisa + $jumlah]);
                Peminjaman::where('id', $id)->update(['status' => 4]);
            }
            return redirect()->back()->with('success', 'Pengembalian berhasil disetujui!.');
        }
        return redirect()->back()->with('warning', 'Belum terdapat data yang dipilih!.');
    }

    public function kembalikan(Request $request)
    {
        $peminjaman = Peminjaman::whereId($request->pem_id)->update(['status' => 3]);
        if ($peminjaman) {
            return redirect()->back()->with('success', 'Pengajuan Berhasil di Lakukan!.');
        } else {
            return redirect()->back()->with('error', 'Gagal diperbarui');
        }
    }
}
