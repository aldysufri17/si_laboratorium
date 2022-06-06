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
    public function __construct(Request $request)
    {
        $this->middleware('auth');
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
                ->get();
        } else {
            if (request()->start_date || request()->end_date) {
                $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
                $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
                $peminjaman = Peminjaman::with('user', 'barang')
                    ->where('kategori_lab', $kategori_lab)
                    ->where('status', '>=', 2)
                    ->whereBetween('updated_at', [$start_date, $end_date])
                    ->get();
            } else {
                $peminjaman = Peminjaman::with('user', 'barang')
                    ->where('kategori_lab', $kategori_lab)
                    ->where('status', '>=', 2)
                    ->get();
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
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $peminjaman = Peminjaman::with('user', 'barang')
                ->where('kategori_lab', $data)
                ->where('status', '>', 2)
                ->whereBetween('updated_at', [$start_date, $end_date])
                ->get();
        } else {
            $peminjaman = Peminjaman::with('user', 'barang')
                ->where('kategori_lab', $data)
                ->where('status', '>', 2)
                ->get();
        }
        return view('backend.transaksi.admin-peminjaman', compact('peminjaman'));
    }

    // Pengajuan
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
            ->select('user_id', DB::raw('count(*) as total'))
            ->where('kategori_lab', $kategori_lab)
            ->where('status', 0)
            ->groupBy('user_id')
            ->get();

        return view('backend.transaksi.konfirmasi.pengajuan.index', compact('peminjaman'));
    }

    public function showPengajuan($id)
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
        $peminjaman = Peminjaman::where('user_id', $id)
            ->select('kode_peminjaman', 'created_at', DB::raw('count(*) as total'))
            ->where('kategori_lab', $kategori_lab)
            ->where('status', 0)
            ->groupBy('kode_peminjaman', 'created_at')
            ->get();
        return view('backend.transaksi.konfirmasi.pengajuan.show', compact('peminjaman', 'id'));
    }

    public function pengajuanDetail($id, $kode)
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
            ->where('user_id', $id)
            ->where('kode_peminjaman', $kode)
            ->get();
        $detail = Peminjaman::with('user', 'barang')
            ->where('kategori_lab', $kategori_lab)
            ->where('kode_peminjaman', $kode)
            ->where('user_id', $id)
            ->first();
        return view('backend.transaksi.konfirmasi.pengajuan-detail', compact('peminjaman', 'detail'));
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
            ->select('user_id', DB::raw('count(*) as total'))
            ->where('kategori_lab', $kategori_lab)
            ->whereBetween('status', [2, 3])
            ->groupBy('user_id')
            ->get();
        return view('backend.transaksi.konfirmasi.peminjaman.index', compact('peminjaman'));
    }

    public function showPeminjaman($id)
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
        $peminjaman = Peminjaman::where('user_id', $id)
            ->select('kode_peminjaman', DB::raw('count(*) as total'))
            ->where('kategori_lab', $kategori_lab)
            ->whereBetween('status', [2, 3])
            ->groupBy('kode_peminjaman')
            ->get();
        return view('backend.transaksi.konfirmasi.peminjaman.show', compact('peminjaman', 'id'));
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
            ->get();
        return view('backend.transaksi.konfirmasi.peminjaman.detail', compact('peminjaman'));
    }

    public function create()
    {
        $barang = Barang::all();
        $user = User::where('role_id', 3)->get();
        return view('backend.transaksi.konfirmasi.peminjaman.add', compact('barang', 'user'));
    }

    public function checkout(Request $request)
    {
        $id_cart = $request->ckd_chld;
        $user_id = Auth::user()->id;
        $keranjang = Keranjang::whereIn('id', $id_cart)->get();
        $jumlah = Keranjang::whereIn('id', $id_cart)->pluck('jumlah');
        $barang_id = Keranjang::whereIn('id', $id_cart)->pluck('barang_id');
        $stok = Barang::whereIn('id', $barang_id)->pluck('stock');
        $nama = Barang::whereIn('id', $barang_id)->pluck('nama');
        $kode_peminjaman = $user_id . substr(str_shuffle("0123456789"), 0, 8);
        // $nama_keranjang = str_replace(' ', '_', strtolower($request->nama_keranjang));
        // // cek nama keranjang
        // $cek = Peminjaman::where('nama_keranjang', $nama_keranjang)->where('user_id', $user_id)->get();
        // if ($cek->isNotEmpty()) {
        //     return redirect()->back()->with('errr', 'Nama Keranjang Sudah Ada...!!');
        // }
        // cek validate tanggal
        if ($request->tgl_end < $request->tgl_start || $request->tgl_start < date('Y-m-d')) {
            return redirect()->back()->with('errr', 'Tanggal peminjaman tidak Valid...!!');
        }
        // cek validate
        if ($request->tgl_end == null || $request->tgl_start == null || $request->alasan == null) {
            return redirect()->back()->with('errr', 'Form Penggunaan Harus Lengkap...!!');
        }

        foreach ($jumlah as $index => $jml) {
            if ($stok[$index] - $jml <= 0 || $stok[$index] == 0) {
                return redirect()->back()->with('errr', "Stok $nama[$index] tidak mencukupi...!!");
            }
        }

        // // dd($keranjang_name);
        foreach ($keranjang as $data) {

            $peminjaman = Peminjaman::create([
                'kode_peminjaman'   => $kode_peminjaman,
                // 'nama_keranjang'    => $nama_keranjang,
                'user_id'           => $user_id,
                'barang_id'         => $data->barang_id,
                'tgl_start'         => $request->tgl_start,
                'tgl_end'           => $request->tgl_end,
                'jumlah'            => $data->jumlah,
                'kategori_lab'      => $data->kategori_lab,
                'alasan'            => $request->alasan,
                'status'            => 0,
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


    public function edit($id)
    {
        $user_id = Auth::user()->id;
        $peminjaman = Peminjaman::with('barang')
            ->where('user_id', $user_id)
            ->where('kode_peminjaman', $id)
            ->first();
        return view('frontend.edit-detail', compact('peminjaman'));
    }

    public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'alasan' => 'required',
            'tgl_start' => 'required',
            'tgl_end' => 'required',
        ]);
        $peminjaman = Peminjaman::where('user_id', $user_id)->where('kode_peminjaman', $id)->update([
            'tgl_start'      => $request->tgl_start,
            'tgl_end'        => $request->tgl_end,
            'alasan'         => $request->alasan,
        ]);
        if ($peminjaman) {
            return redirect()->route('daftar.pinjaman')->with('success', 'Barang Berhasil di edit!.');
        } else {
            return redirect()->back()->with('error', 'Gagal ditambah');
        }
    }

    public function destroy($id, Request $request)
    {

        if ($id == 1) {
            $pem = $request->delete_id;
            $barang_id = Peminjaman::where('id', $pem)->value('barang_id');
            $user_id = Peminjaman::where('id', $pem)->value('user_id');
            Keranjang::where('user_id', $user_id)->where('barang_id', $barang_id)->delete();
            $peminjaman = Peminjaman::where('id', $pem)->delete();
            if ($peminjaman) {
                return redirect()->back()->with('success', 'Barang Berhasil dihapus!.');
            } else {
                return redirect()->back()->with('error', 'Barang Gagal dihapus!.');
            }
        } else {
            // Delete peminjaman dari Peminjam
            if (Auth::user()->role_id == 1) {
                $pem = $request->delete_id;
                $user_id = Auth::user()->id;
                $jumlah = Peminjaman::where('user_id', $user_id)
                    ->where('kode_peminjaman', $pem)
                    ->pluck('jumlah');
                $barang_id = Peminjaman::where('user_id', $user_id)
                    ->where('kode_peminjaman', $pem)
                    ->pluck('barang_id');
                $stock = Barang::whereIn('id', $barang_id)->pluck('stock');
                foreach ($barang_id as $index => $id) {
                    Barang::whereid($id)->update(['stock' => $stock[$index] + $jumlah[$index]]);
                    Keranjang::where('user_id', $user_id)
                        ->where('barang_id', $id)
                        ->delete();
                }
                $peminjaman = Peminjaman::where('user_id', $user_id)
                    ->where('kode_peminjaman', $pem)
                    ->delete();
                if ($peminjaman) {
                    return redirect()->back()->with('success', 'Keranjang Berhasil dihapus!.');
                } else {
                    return redirect()->back()->with('error', 'Keranjang Gagal dihapus!.');
                }
            } else {
                // Delete Peminjaman dari Operator
                if (Auth::user()->role_id == 3) {
                    $kategori_lab = 1;
                } elseif (Auth::user()->role_id == 4) {
                    $kategori_lab = 2;
                } elseif (Auth::user()->role_id == 5) {
                    $kategori_lab = 3;
                } elseif (Auth::user()->role_id == 6) {
                    $kategori_lab = 4;
                }
                $kode = $request->deletekode;
                $user_id = $request->deleteuser_id;
                $jumlah = Peminjaman::where('user_id', $user_id)
                    ->where('kode_peminjaman', $kode)
                    ->where('kategori_lab', $kategori_lab)
                    ->pluck('jumlah');
                $barang_id = Peminjaman::where('user_id', $user_id)
                    ->where('kode_peminjaman', $kode)
                    ->where('kategori_lab', $kategori_lab)
                    ->pluck('barang_id');
                $stock = Barang::whereIn('id', $barang_id)->pluck('stock');
                foreach ($barang_id as $index => $id) {
                    Barang::whereid($id)->update(['stock' => $stock[$index] + $jumlah[$index]]);
                    Keranjang::where('user_id', $user_id)
                        ->where('kategori_lab', $kategori_lab)
                        ->where('barang_id', $id)
                        ->delete();
                }
                $peminjaman = Peminjaman::where('user_id', $user_id)
                    ->where('kode_peminjaman', $kode)
                    ->where('kategori_lab', $kategori_lab)
                    ->delete();
                if ($peminjaman) {
                    return redirect()->route('konfirmasi.peminjaman')->with('success', 'Keranjang Berhasil dihapus!.');
                } else {
                    return redirect()->back()->with('error', 'Keranjang Gagal dihapus!.');
                }
            }
        }
    }

    public function statusPeminjaman($id, $kode, $status, Request $request)
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
        if ($status == 2) {
            $barang_id = Peminjaman::where('user_id', $id)
                ->where('kode_peminjaman', $kode)
                ->where('kategori_lab', $kategori_lab)
                ->pluck('barang_id');
            $jumlah = Peminjaman::where('user_id', $id)
                ->where('kode_peminjaman', $kode)
                ->where('kategori_lab', $kategori_lab)
                ->pluck('jumlah');
            $stock = Barang::whereIn('id', $barang_id)
                ->pluck('stock');
            $telat = Peminjaman::where('user_id', $id)
                ->where('kode_peminjaman', $kode)
                ->where('kategori_lab', $kategori_lab)
                ->first();
            if ($telat->tgl_end < date('Y-m-d')) {
                return redirect()->back()->with('warning', 'Konfirmasi pengajuan telat!.');
            }

            foreach ($barang_id as $index => $barang) {
                $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
                // Mutasi
                $inventaris = Inventaris::create([
                    'barang_id'         => $barang,
                    'status'            => 0,
                    'deskripsi'         => "Pinjam",
                    'kode_mutasi'       => 'OUT' . $random,
                    'kode_inventaris'   => 'OUT' . $random,
                    'masuk'             => 0,
                    'keluar'            => $jumlah[$index],
                    'kategori_lab'      => $kategori_lab,
                    'total'             => $stock[$index] - $jumlah[$index],
                    'stok'              => 0
                ]);
                Barang::whereid($barang)->update(['stock' => $stock[$index] - $jumlah[$index]]);
                Peminjaman::where('user_id', $id)
                    ->where('kode_peminjaman', $kode)
                    ->where('barang_id', $barang)
                    ->where('kategori_lab', $kategori_lab)
                    ->update(['status' => $status]);
            }

            if ($inventaris) {
                return redirect()->back()->with('success', 'Peminjaman Berhasil di Setujui!.');
            }
        } elseif ($status == 4) {
            $kode = $request->terimakode;
            $user_id = $request->terimauser_id;
            $barang_id = Peminjaman::where('user_id', $user_id)
                ->where('kode_peminjaman', $kode)
                ->where('kategori_lab', $kategori_lab)
                ->pluck('barang_id');
            $jumlah = Peminjaman::where('user_id', $user_id)
                ->where('kode_peminjaman', $kode)
                ->where('kategori_lab', $kategori_lab)
                ->pluck('jumlah');
            $stock = Barang::whereIn('id', $barang_id)
                ->pluck('stock');
            $telat = Peminjaman::where('user_id', $user_id)
                ->where('kode_peminjaman', $kode)
                ->where('kategori_lab', $kategori_lab)
                ->first();

            foreach ($barang_id as $index => $barang) {
                $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
                // Mutasi
                $inventaris = Inventaris::create([
                    'barang_id'         => $barang,
                    'status'            => 1,
                    'deskripsi'         => "Selesai",
                    'kode_mutasi'       => 'IN' . $random,
                    'kode_inventaris'   => 'IN' . $random,
                    'masuk'             => $jumlah[$index],
                    'keluar'            => 0,
                    'kategori_lab'      => $kategori_lab,
                    'total'             => $stock[$index] + $jumlah[$index],
                    'stok'              => 0
                ]);
                Barang::whereid($barang)->update(['stock' => $stock[$index] + $jumlah[$index]]);
                Peminjaman::where('user_id', $id)
                    ->where('kode_peminjaman', $kode)
                    ->where('barang_id', $barang)
                    ->where('kategori_lab', $kategori_lab)
                    ->update(['status' => $status]);
                Keranjang::where('user_id', $user_id)->where('barang_id', $barang)->delete();
            }

            if ($inventaris) {
                return redirect()->back()->with('success', 'Pengembalian barang berhasil diterima!.');
            }
        }
    }

    public function tolak(Request $request)
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
        $kode = $request->kode;
        $pesan = $request->pesan;
        $user_id = $request->user_id;
        if ($pesan == null) {
            $pesan = "Terdapat Kesalahan Data";
        }
        $peminjaman = Peminjaman::where('kode_peminjaman', $kode)
            ->where('kategori_lab', $kategori_lab)
            ->where('user_id', $user_id)
            ->update(['status' => 1, 'pesan' => $pesan]);
        if ($peminjaman) {
            return redirect()->back()->with('success', 'Pengajuan Berhasil di Tolak!.');
        } else {
            return redirect()->back()->with('error', 'Gagal diperbarui');
        }
    }

    public function kembalikan(Request $request)
    {
        $user_id = Auth::user()->id;
        $kode = $request->pem_id;
        $peminjaman = Peminjaman::where('kode_peminjaman', $kode)->where('user_id', $user_id)->update(['status' => 3]);
        if ($peminjaman) {
            return redirect()->back()->with('success', 'Pengajuan Berhasil di Lakukan!.');
        } else {
            return redirect()->back()->with('error', 'Gagal diperbarui');
        }
    }

    public function scanPengembalian()
    {
        return view('backend.transaksi.konfirmasi.peminjaman.scan');
    }


    public function scanStore($id)
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

        $cek = Peminjaman::where('kode_peminjaman', $id)->get();
        if ($cek->isEmpty()) {
            return redirect()->back()->with('info', 'QR-Code tidak ditemukan!.');
        }

        $ceksts = Peminjaman::where('kode_peminjaman', $id)->where('status', '<', 3)->get();
        if ($ceksts->IsNotEmpty()) {
            return redirect()->back()->with('info', 'Masih Terdapat Proses Peminjaman!.');
        } else {
            $cekcld = Peminjaman::where('kode_peminjaman', $id)->where('status', 4)->get();
            if ($cekcld->IsNotEmpty()) {
                return redirect()->back()->with('info', 'Peminjaman Sudah dikembalikan!.');
            } else {
                $barang_id = Peminjaman::where('kode_peminjaman', $id)
                    ->where('kategori_lab', $kategori_lab)
                    ->pluck('barang_id');

                $jumlah = Peminjaman::where('kode_peminjaman', $id)
                    ->where('kategori_lab', $kategori_lab)
                    ->pluck('jumlah');

                $user_id = Peminjaman::where('kode_peminjaman', $id)
                    ->where('kategori_lab', $kategori_lab)
                    ->first();
                $user = $user_id->user_id;

                $stock = Barang::whereIn('id', $barang_id)
                    ->pluck('stock');


                foreach ($barang_id as $index => $barang) {
                    $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
                    // Mutasi
                    Inventaris::create([
                        'barang_id'         => $barang,
                        'status'            => 1,
                        'deskripsi'         => "Selesai",
                        'kode_mutasi'       => 'IN' . $random,
                        'kode_inventaris'   => 'IN' . $random,
                        'masuk'             => $jumlah[$index],
                        'keluar'            => 0,
                        'kategori_lab'      => $kategori_lab,
                        'total'             => $stock[$index] + $jumlah[$index],
                        'stok'              => 0
                    ]);
                    Barang::whereid($barang)->update(['stock' => $stock[$index] + $jumlah[$index]]);
                    Peminjaman::where('user_id', $user)
                        ->where('kode_peminjaman', $id)
                        ->where('barang_id', $barang)
                        ->where('kategori_lab', $kategori_lab)
                        ->update(['status' => 4]);
                    Keranjang::where('user_id', $user)->where('barang_id', $barang)->delete();
                }
                return redirect()->back()->with('success', 'Pengembalian berhasil disetujui!.');
            }
        }
    }
    public function print(Request $request)
    {
        $user_id = Auth::user()->id;
        $name = Auth::user()->name;
        $nim = Auth::user()->nim;
        $alamat = Auth::user()->alamat;
        $id_peminjaman = $request->id_peminjaman;
        $cek = Peminjaman::where('kode_peminjaman', $id_peminjaman)
            ->where('user_id', $user_id)
            ->where('status', 0)
            ->get();
        if ($cek->isNotEmpty()) {
            return redirect()->back()->with('info', 'Terdapat pengajuan yang belum disetujui!.');
        }
        $peminjaman = Peminjaman::where('kode_peminjaman', $id_peminjaman)
            ->where('user_id', $user_id)
            ->where('status', '>', 1)
            ->get();
        $detail = $peminjaman->first();
        // $nama_keranjang = strtoupper($detail->nama_keranjang);
        $pdf = PDF::loadview('frontend.surat-peminjaman', compact('peminjaman', 'name', 'nim', 'alamat', 'detail'));
        // return view('frontend.surat', ['peminjaman' => $peminjaman, 'name' => $name, 'nim' => $nim, 'alamat' => $alamat]);

        return $pdf->download("Surat Peminjaman" . "_" . $detail->kode_peminjaman . "_" . $name . '_' . $nim . '.pdf');
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
}
