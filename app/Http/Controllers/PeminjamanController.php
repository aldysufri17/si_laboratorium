<?php

namespace App\Http\Controllers;

use App\Exports\PeminjamanExport;
use App\Models\Barang;
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
                    ->where('status', '>', 2)
                    ->whereBetween('date', [$start_date, $end_date])
                    ->paginate(5);
            } else {
                $peminjaman = Peminjaman::with('user', 'barang')
                    ->where('kategori_lab', $kategori_lab)
                    ->where('status', '>', 2)
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
            ->where('status', '=', 2)
            ->groupBy('date')
            ->paginate(5);
        return view('backend.transaksi.konfirmasi.peminjaman.index', compact('peminjaman'));
    }

    public function konfirmasiPeminjamanDetail($data)
    {
        $peminjaman = Peminjaman::with('user', 'barang')
            ->where('date', $data)
            ->where('status', '=', 2)
            ->paginate(5);
        return view('backend.transaksi.konfirmasi.peminjaman.detail', compact('peminjaman'));
    }

    // public function create()
    // {
    //     $barang = Barang::all();
    //     $user = User::where('role_id', 3)->get();
    //     return view('backend.transaksi.konfirmasi.peminjaman.add', compact('barang', 'user'));
    // }

    public function store(Request $request, $id)
    {
        $barang = Barang::whereId($id)->first();
        $stok = $barang->stock;
        $kategori_lab = $barang->kategori_lab;
        if ($request->jumlah > $stok) {
            return redirect()->back()->with('eror', 'Stok Barang tidak mencukupi...!!');
        } elseif ($request->tgl_end < $request->tgl_start) {
            return redirect()->back()->with('eror', 'Tanggal peminjaman tidak falid...!!');
        } else {
            $request->validate([
                'jumlah' => 'required',
                'alasan' => 'required',
                'tgl_start' => 'required',
                'tgl_end' => 'required',
            ]);
            $user_id = Auth::user()->id;
            $peminjaman = Peminjaman::create([
                'id'        => substr(str_shuffle("0123456789"), 0, 8),
                'user_id'   => $user_id,
                'barang_id' => $id,
                'tgl_start' => $request->tgl_start,
                'tgl_end'   => $request->tgl_end,
                'jumlah'    => $request->jumlah,
                'kategori_lab'  => $kategori_lab,
                'alasan'    => $request->alasan,
                'status'    => 0,
                'date'      => date('Y-m-d')
            ]);
            if ($peminjaman) {
                return redirect()->route('cart')->with('success', 'Barang Berhasil di tambah!.');
            } else {
                return redirect()->back()->with('error', 'Gagal ditambah');
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
            return redirect()->route('cart')->with('success', 'Barang Berhasil di edit!.');
        } else {
            return redirect()->back()->with('error', 'Gagal ditambah');
        }
    }

    public function destroy($id, Request $request)
    {
        $pem = $request->delete_id;
        $peminjaman = Peminjaman::where('id', $pem)->delete();
        if ($peminjaman) {
            return redirect()->back()->with('success', 'Barang Berhasil dihapus!.');
        } else {
            return redirect()->back()->with('error', 'Barang Gagal dihapus!.');
        }
    }


    public function konfirmasiStatus($user_id, $status, $barang_id, $jumlah)
    {
        if ($status == 3) {
            $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            $sisa = Barang::where('id', $barang_id)->first();
            $total = $sisa->stock;
            $kategori_lab = $sisa->kategori_lab;
            if ($total - $jumlah < 0) {
                return redirect()->back()->with('warning', 'Inventaris Barang tidak mencukupi!.');
            }
            $inventaris = Inventaris::create([
                'barang_id'         => $barang_id,
                'status'            => 0,
                'deskripsi'         => "Active",
                'kode_inventaris'   => 'OUT' . $random,
                'masuk'             => 0,
                'keluar'            => $jumlah,
                'kategori_lab'      => $kategori_lab,
                'total'             => $total - $jumlah,
            ]);
            Barang::whereid($barang_id)->update(['stock' => $total - $jumlah]);
            Peminjaman::whereId($user_id)->update(['status' => $status]);
            if ($inventaris) {
                return redirect()->back()->with('success', 'Peminjaman Berhasil di Setujui!.');
            }
        } elseif ($status == 4) {
            $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            $sisa = Barang::where('id', $barang_id)->first();
            $total = $sisa->stock;
            $kategori_lab = $sisa->kategori_lab;
            $inventaris = Inventaris::create([
                'barang_id'         => $barang_id,
                'status'            => 1,
                'deskripsi'         => "Clear",
                'kode_inventaris'   => 'IN' . $random,
                'masuk'             => $jumlah,
                'keluar'            => 0,
                'kategori_lab'      => $kategori_lab,
                'total'             => $total + $jumlah,
            ]);
            Barang::whereId($barang_id)->update(['stock' => $total + $jumlah]);
            Peminjaman::whereId($user_id)->update(['status' => $status]);
            if ($inventaris) {
                return redirect()->back()->with('success', 'Pengembalian Berhasil di Setujui!.');
            }
        } elseif ($status == 2) {
            $peminjaman = Peminjaman::whereId($user_id)->update(['status' => $status]);
            if ($peminjaman) {
                return redirect()->back()->with('success', 'Pengajuan Berhasil di Setujui!.');
            } else {
                return redirect()->back()->with('error', 'Gagal diperbarui');
            }
        } else {
            $peminjaman = Peminjaman::whereId($user_id)->update(['status' => $status]);
            if ($peminjaman) {
                return redirect()->back()->with('info', 'Pengajuan Berhasil di Tolak!.');
            } else {
                return redirect()->back()->with('error', 'Gagal diperbarui');
            }
        }
    }


    // Konfirmasi Pengembalian
    public function pengembalian()
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
            ->where('status', 3)
            ->paginate(5);
        return view('backend.transaksi.konfirmasi.pengembalian.index', compact('peminjaman'));
    }

    public function scan($status)
    {
        if ($status == 'peminjaman') {
            return view('backend.transaksi.konfirmasi.peminjaman.scan');
        } else {
            return view('backend.transaksi.konfirmasi.pengembalian.scan');
        }
    }

    public function scanStore($id, $status)
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

        // Status 1 = peminjaman
        // Status 0 = Pengembalian
        $id_peminjaman = intval($id);
        $sts = intval($status);
        $cek = Peminjaman::whereid($id_peminjaman)->get();
        if ($cek->isEmpty()) {
            return redirect()->back()->with('info', 'Barcode barang tidak ditemukan!.');
        }
        $cekaja = Peminjaman::whereid($id_peminjaman)->first();

        if ($sts == 1) {
            // Peminjaman
            // dd($cekaja->status);
            if ($cekaja->status < 3) {
                $barang = Peminjaman::whereid($id_peminjaman)->value('barang_id');
                $jumlah = Peminjaman::whereid($id_peminjaman)->value('jumlah');
                $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
                $sisa = Barang::whereId(intval($barang))->value('stock');
                if ($sisa - $jumlah < 0) {
                    return redirect()->back()->with('warning', 'Inventaris Barang tidak mencukupi!.');
                }
                Inventaris::create([
                    'barang_id'         => intval($barang),
                    'kategori_lab'      => $kategori_lab,
                    'status'            => 0,
                    'deskripsi'         => "Active",
                    'kode_inventaris'   => 'OUT' . $random,
                    'masuk'             => 0,
                    'keluar'            => $jumlah,
                    'total'             => $sisa - $jumlah,
                ]);
                Barang::whereId($barang)->update(['stock' => $sisa - $jumlah]);
                Peminjaman::whereId($id_peminjaman)->where('status', 2)->update(['status' => 3]);
                return redirect()->back()->with('success', 'Peminjaman berhasil disetujui!.');
            } else if ($cekaja->status == 3) {
                return redirect()->back()->with('success', 'Peminjaman berhasil disetujui!.');
            } else if ($cekaja->status > 3) {
                return redirect()->back()->with('warning', 'Tidak terdaftar dalam aktivasi peminjaman!.');
            }
        } else {
            if ($cekaja->status == 3) {
                $barang = Peminjaman::whereid($id_peminjaman)->value('barang_id');
                $jumlah = Peminjaman::whereid($id_peminjaman)->value('jumlah');
                $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
                $sisa = Barang::whereId($barang)->value('stock');
                Inventaris::create([
                    'barang_id'         => $barang,
                    'kategori_lab'      => $kategori_lab,
                    'status'            => 1,
                    'deskripsi'         => "Clear",
                    'kode_inventaris'   => 'IN' . $random,
                    'masuk'             => $jumlah,
                    'keluar'            => 0,
                    'total'             => $sisa + $jumlah,
                ]);
                Barang::whereId($barang)->update(['stock' => $sisa + $jumlah]);
                Peminjaman::whereId($id_peminjaman)->where('status', 3)->update(['status' => 4]);
                return redirect()->back()->with('success', 'Pengembalian berhasil disetujui!.');
            } else if (($cekaja->status < 3)) {
                return redirect()->back()->with('warning', 'Peminjaman belum aktif!.');
            } else if ($cekaja->status == 4) {
                return redirect()->back()->with('success', 'Pengembalian berhasil disetujui!.');
            }
        }
    }

    public function print()
    {
        $user_id = Auth::user()->id;
        $name = Auth::user()->name;
        $nim = Auth::user()->nim;
        $alamat = Auth::user()->alamat;
        $peminjaman = Peminjaman::where('user_id', $user_id)->where('status', '>=', 2)->get();
        $pdf = PDF::loadview('frontend.surat-peminjaman', ['peminjaman' => $peminjaman, 'name' => $name, 'nim' => $nim, 'alamat' => $alamat]);
        // return view('frontend.surat', ['peminjaman' => $peminjaman, 'name' => $name, 'nim' => $nim, 'alamat' => $alamat]);

        if ($peminjaman->isEmpty()) {
            return redirect()->back()->with('info', 'Belum terdapat pengajuan disetujui!.');
        }
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
        $id = $request->ckd_chld;
        if ($id) {
            foreach ($id as $user) {
                Peminjaman::where('id', $user)->update(['status' => 4]);
            }
            return redirect()->back()->with('success', 'Pengembalian berhasil disetujui!.');
        }
        return redirect()->back()->with('warning', 'Belum terdapat data yang dipilih!.');
    }
}
