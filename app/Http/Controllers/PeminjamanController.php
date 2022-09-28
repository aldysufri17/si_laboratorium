<?php

namespace App\Http\Controllers;

use App\Exports\PeminjamanExport;
use App\Models\Barang;
use App\Models\Keranjang;
use App\Models\Peminjaman;
use App\Models\Inventaris;
use App\Models\Laboratorium;
use App\Models\Surat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;

class PeminjamanController extends Controller
{
    protected $lab;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->lab = Auth::user()->post;
            return $next($request);
        });
    }

    // Riwayat
    public function index()
    {
        if (Auth::user()->role == 2) {
            if (request()->start_date || request()->end_date) {
                $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
                $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
                $peminjaman = Peminjaman::with('user', 'barang')
                    ->where('status', 4)
                    ->select('kode_peminjaman', 'created_at', 'user_id', DB::raw('count(*) as total'))
                    ->groupBy('kode_peminjaman', 'created_at', 'user_id',)
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->get();
            } else {
                $peminjaman = Peminjaman::with('user', 'barang')
                    ->where('status', 4)
                    ->select('kode_peminjaman', 'created_at', 'user_id', DB::raw('count(*) as total'))
                    ->groupBy('kode_peminjaman', 'created_at', 'user_id')
                    ->get();
            }
        } else {
            if (request()->start_date || request()->end_date) {
                $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
                $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
                $peminjaman = Peminjaman::with('user', 'barang')
                    ->whereHas('barang', function ($q) {
                        $q->where('laboratorium_id', $this->lab);
                    })
                    ->where('status', 4)
                    ->select('kode_peminjaman', 'updated_at', 'user_id', DB::raw('count(*) as total'))
                    ->groupBy('kode_peminjaman', 'updated_at', 'user_id',)
                    ->whereBetween('updated_at', [$start_date, $end_date])
                    ->get();
            } else {
                $peminjaman = Peminjaman::with('user', 'barang')
                    ->whereHas('barang', function ($q) {
                        $q->where('laboratorium_id', $this->lab);
                    })
                    ->where('status', 4)
                    ->select('kode_peminjaman', 'updated_at', 'user_id', DB::raw('count(*) as total'))
                    ->groupBy('kode_peminjaman', 'updated_at', 'user_id')
                    ->get();
            }
        }
        return view('backend.transaksi.riwayat', compact('peminjaman'));
    }

    // Pengajuan
    public function pengajuan()
    {
        $peminjaman = Peminjaman::withCount('user')
            ->select('user_id', DB::raw('count(*) as total'))
            ->whereHas('barang', function ($q) {
                $q->where('laboratorium_id', $this->lab);
            })
            ->where('status', 0)
            ->groupBy('user_id')
            ->get();

        return view('backend.transaksi.pengajuan.index', compact('peminjaman'));
    }

    // public function pengajuanAll($id)
    // {
    //     if ($id == 1) {
    //         Peminjaman::where('status', 0)
    //             ->whereHas('barang', function ($q) {
    //                 $q->where('laboratorium_id', $this->lab);
    //             })
    //             ->update(['status' => 1]);
    //     } elseif ($id == 3) {
    //         $peminjaman = Peminjaman::where('status', 3)
    //             ->whereHas('barang', function ($q) {
    //                 $q->where('laboratorium_id', $this->lab);
    //             })
    //             ->first();
    //         if ($peminjaman) {
    //             Peminjaman::where('status', 3)
    //                 ->whereHas('barang', function ($q) {
    //                     $q->where('laboratorium_id', $this->lab);
    //                 })
    //                 ->update(['status' => 4]);
    //         } else {
    //             return redirect()->back()->with('info', 'Belum terdapat pengajuan pengembalian.!');
    //         }
    //     } else {
    //         Peminjaman::where('status', 0)
    //             ->whereHas('barang', function ($q) {
    //                 $q->where('laboratorium_id', $this->lab);
    //             })
    //             ->pluck('barang_id');
    //         Peminjaman::where('status', 0)
    //             ->whereHas('barang', function ($q) {
    //                 $q->where('laboratorium_id', $this->lab);
    //             })
    //             ->pluck('jumlah');
    //         Peminjaman::where('status', 0)
    //             ->whereHas('barang', function ($q) {
    //                 $q->where('laboratorium_id', $this->lab);
    //             })
    //             ->update(['status' => 2]);
    //     }

    //     return redirect()->back()->with('success', 'Status Pengajuan Berhasil diubah.!');
    // }

    public function showPengajuan($id)
    {
        $id = decrypt($id);
        $peminjaman = Peminjaman::where('user_id', $id)
            ->select('kode_peminjaman', 'updated_at', DB::raw('count(*) as total'))
            ->whereHas('barang', function ($q) {
                $q->where('laboratorium_id', $this->lab);
            })
            ->where('status', 0)
            ->groupBy('kode_peminjaman', 'updated_at')
            ->get();
        return view('backend.transaksi.pengajuan.show', compact('peminjaman', 'id'));
    }

    public function pengajuanDetail($id, $kode)
    {
        $kode = decrypt($kode);
        $peminjaman = Peminjaman::with('user', 'barang')
            ->whereHas('barang', function ($q) {
                $q->where('laboratorium_id', $this->lab);
            })
            ->where('user_id', $id)
            ->where('kode_peminjaman', $kode)
            ->get();
        $detail = Peminjaman::with('user', 'barang')
            ->whereHas('barang', function ($q) {
                $q->where('laboratorium_id', $this->lab);
            })
            ->where('kode_peminjaman', $kode)
            ->where('user_id', $id)
            ->first();
        return view('backend.transaksi.pengajuan.detail-pengajuan', compact('peminjaman', 'detail'));
    }


    // Peminjaman
    public function peminjaman()
    {
        $peminjaman = Peminjaman::withCount('user')
            ->select('user_id', DB::raw('count(*) as total'))
            ->whereHas('barang', function ($q) {
                $q->where('laboratorium_id', $this->lab);
            })
            ->whereBetween('status', [2, 3])
            ->groupBy('user_id')
            ->get();
        return view('backend.transaksi.peminjaman.index', compact('peminjaman'));
    }

    public function showPeminjaman($id)
    {
        $id = decrypt($id);
        $peminjaman = Peminjaman::where('user_id', $id)
            ->select('kode_peminjaman', DB::raw('count(*) as total'))
            ->whereHas('barang', function ($q) {
                $q->where('laboratorium_id', $this->lab);
            })
            ->whereBetween('status', [2, 3])
            ->groupBy('kode_peminjaman')
            ->get();
        return view('backend.transaksi.peminjaman.show', compact('peminjaman', 'id'));
    }

    public function peminjamanDetail($id, $kode)
    {
        $kode = decrypt($kode);
        $peminjaman = Peminjaman::with('user', 'barang')
            ->whereHas('barang', function ($q) {
                $q->where('laboratorium_id', $this->lab);
            })
            ->where('user_id', $id)
            ->where('kode_peminjaman', $kode)
            ->get();
        $detail = Peminjaman::with('user', 'barang')
            ->whereHas('barang', function ($q) {
                $q->where('laboratorium_id', $this->lab);
            })
            ->where('kode_peminjaman', $kode)
            ->where('user_id', $id)
            ->first();
        return view('backend.transaksi.peminjaman.detail-peminjaman', compact('peminjaman', 'detail'));
    }

    public function destroy($id, Request $request)
    {

        if ($id == 1) {
            $pem = $request->delete_id;
            $peminjaman = Peminjaman::where('id', $pem)->delete();
            if ($peminjaman) {
                return redirect()->back()->with('success', 'Barang Berhasil dihapus!.');
            } else {
                return redirect()->back()->with('error', 'Barang Gagal dihapus!.');
            }
        } else {
            // Delete peminjaman dari Peminjam
            if (Auth::user()->role == 1) {
                $kode = $request->delete_id;
                $user_id = Auth::user()->id;
                $peminjaman = Peminjaman::where('user_id', $user_id)
                    ->where('kode_peminjaman', $kode)
                    ->delete();
                if ($peminjaman) {
                    return redirect()->back()->with('success', 'Peminjaman Berhasil dihapus!.');
                } else {
                    return redirect()->back()->with('error', 'Peminjaman Gagal dihapus!.');
                }
            } else {
                // Delete Peminjaman dari Operator
                $pem_id = $request->delete_id;
                $jumlah = Peminjaman::whereId($pem_id)->value('jumlah');
                $barang_id = Peminjaman::whereId($pem_id)->value('barang_id');

                $stock = Barang::whereId($barang_id)->value('stock');
                $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
                // Mutasi
                Inventaris::create([
                    'barang_id'         => $barang_id,
                    'status'            => 1,
                    'deskripsi'         => "Selesai",
                    'kode_mutasi'       => 'IN' . $random,
                    'kode_inventaris'   => 'IN' . $random,
                    'masuk'             => $jumlah,
                    'keluar'            => 0,
                    'total_mutasi'      => $stock + $jumlah,
                    'total_inventaris'  => 0
                ]);
                Barang::whereid($barang_id)->update(['stock' => $stock + $jumlah]);

                $peminjaman = Peminjaman::whereId($pem_id)->delete();
                if ($peminjaman) {
                    return redirect()->back()->with('success', 'Peminjaman Berhasil dihapus!.');
                } else {
                    return redirect()->back()->with('error', 'Peminjaman Gagal dihapus!.');
                }
            }
        }
    }

    public function statusPeminjaman($id, $kode, $status, Request $request)
    {
        $kode = decrypt($kode);
        if ($status == 2) {
            $barang_id = Peminjaman::where('user_id', $id)
                ->where('kode_peminjaman', $kode)
                ->whereHas('barang', function ($q) {
                    $q->where('laboratorium_id', $this->lab);
                })
                ->pluck('barang_id');
            $jumlah = Peminjaman::where('user_id', $id)
                ->where('kode_peminjaman', $kode)
                ->whereHas('barang', function ($q) {
                    $q->where('laboratorium_id', $this->lab);
                })
                ->pluck('jumlah');
            $stock = Barang::whereIn('id', $barang_id)
                ->pluck('stock');
            $telat = Peminjaman::where('user_id', $id)
                ->where('kode_peminjaman', $kode)
                ->whereHas('barang', function ($q) {
                    $q->where('laboratorium_id', $this->lab);
                })
                ->first();
            if ($telat->tgl_end < date('Y-m-d')) {
                return redirect()->back()->with('warning', 'Konfirmasi pengajuan telat!.');
            }

            foreach ($barang_id as $index => $barang) {
                $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
                if ($jumlah[$index] > $stock[$index]) {
                    $nama = Barang::whereId($barang)->value('nama');
                    return redirect()->back()->with('warning', "Stok barang $nama tidak cukup!.");
                } else {
                    // Mutasi
                    $inventaris = Inventaris::create([
                        'barang_id'         => $barang,
                        'status'            => 0,
                        'deskripsi'         => "Pinjam",
                        'kode_mutasi'       => 'OUT' . $random,
                        'kode_inventaris'   => 'OUT' . $random,
                        'masuk'             => 0,
                        'keluar'            => $jumlah[$index],
                        'total_mutasi'             => $stock[$index] - $jumlah[$index],
                        'total_inventaris'              => 0
                    ]);
                    Barang::whereid($barang)->update(['stock' => $stock[$index] - $jumlah[$index]]);
                    Peminjaman::where('user_id', $id)
                        ->where('kode_peminjaman', $kode)
                        ->where('barang_id', $barang)
                        ->whereHas('barang', function ($q) {
                            $q->where('laboratorium_id', $this->lab);
                        })
                        ->update(['status' => $status]);
                }
                return redirect()->back()->with('success', 'Peminjaman Berhasil di Setujui!.');
            }
        } elseif ($status == 4) {
            $kode = $request->terimakode;
            $user_id = $request->terimauser_id;
            $barang_id = Peminjaman::where('user_id', $user_id)
                ->where('kode_peminjaman', $kode)
                ->whereHas('barang', function ($q) {
                    $q->where('laboratorium_id', $this->lab);
                })
                ->pluck('barang_id');
            $jumlah = Peminjaman::where('user_id', $user_id)
                ->where('kode_peminjaman', $kode)
                ->whereHas('barang', function ($q) {
                    $q->where('laboratorium_id', $this->lab);
                })
                ->pluck('jumlah');
            $stock = Barang::whereIn('id', $barang_id)
                ->pluck('stock');
            $telat = Peminjaman::where('user_id', $user_id)
                ->where('kode_peminjaman', $kode)
                ->whereHas('barang', function ($q) {
                    $q->where('laboratorium_id', $this->lab);
                })
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
                    'total_mutasi'      => $stock[$index] + $jumlah[$index],
                    'total_inventaris'  => 0
                ]);
                Barang::whereid($barang)
                    ->update(['stock' => $stock[$index] + $jumlah[$index]]);
                Peminjaman::where('user_id', $id)
                    ->where('kode_peminjaman', $kode)
                    ->where('barang_id', $barang)
                    ->whereHas('barang', function ($q) {
                        $q->where('laboratorium_id', $this->lab);
                    })
                    ->update(['status' => $status]);
                // Keranjang::where('user_id', $user_id)->where('barang_id', $barang)->delete();
            }

            if ($inventaris) {
                return redirect()->back()->with('success', 'Pengembalian barang berhasil diterima!.');
            }
        }
    }

    public function tolak(Request $request)
    {
        $kode = $request->kode;
        $pesan = $request->pesan;
        $user_id = $request->user_id;
        if ($pesan == null) {
            $pesan = "Terdapat Kesalahan Data";
        }
        $peminjaman = Peminjaman::where('kode_peminjaman', $kode)
            ->whereHas('barang', function ($q) {
                $q->where('laboratorium_id', $this->lab);
            })
            ->where('user_id', $user_id)
            ->update(['status' => 1, 'pesan' => $pesan]);
        if ($peminjaman) {
            return redirect()->back()->with('success', 'Pengajuan Berhasil di Tolak!.');
        } else {
            return redirect()->back()->with('error', 'Gagal diperbarui');
        }
    }

    public function scanPengembalian()
    {
        return view('backend.transaksi.peminjaman.scan');
    }

    public function scanStore($id)
    {
        $cek = Peminjaman::where('kode_peminjaman', $id)->get();
        if ($cek->isEmpty()) {
            return redirect()->back()->with('info', 'QR-Code tidak ditemukan!.');
        }

        $ceksts = Peminjaman::where('kode_peminjaman', $id)->where('status', '<', 3)->get();
        if ($ceksts->IsNotEmpty()) {
            return redirect()->back()->with('info', 'Masih Terdapat Proses Peminjaman!.');
        } else {
            $cekcld = Peminjaman::where('kode_peminjaman', $id)
                ->where('status', 4)
                ->whereHas('barang', function ($q) {
                    $q->where('laboratorium_id', $this->lab);
                })
                ->get();
            if ($cekcld->IsNotEmpty()) {
                return redirect()->back()->with('info', 'Peminjaman Sudah dikembalikan!.');
            } else {
                $barang_id = Peminjaman::where('kode_peminjaman', $id)
                    ->whereHas('barang', function ($q) {
                        $q->where('laboratorium_id', $this->lab);
                    })
                    ->pluck('barang_id');

                $jumlah = Peminjaman::where('kode_peminjaman', $id)
                    ->whereHas('barang', function ($q) {
                        $q->where('laboratorium_id', $this->lab);
                    })
                    ->pluck('jumlah');

                $user_id = Peminjaman::where('kode_peminjaman', $id)
                    ->whereHas('barang', function ($q) {
                        $q->where('laboratorium_id', $this->lab);
                    })
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
                        'total_mutasi'      => $stock[$index] + $jumlah[$index],
                        'total_inventaris'  => 0
                    ]);
                    Barang::whereid($barang)->update(['stock' => $stock[$index] + $jumlah[$index]]);
                    Peminjaman::where('user_id', $user)
                        ->where('kode_peminjaman', $id)
                        ->where('barang_id', $barang)
                        ->whereHas('barang', function ($q) {
                            $q->where('laboratorium_id', $this->lab);
                        })
                        ->update(['status' => 4]);
                    // Keranjang::where('user_id', $user)->where('barang_id', $barang)->delete();
                }
                return redirect()->back()->with('success', 'Pengembalian berhasil disetujui!.');
            }
        }
    }

    public function export($data)
    {
        if (Auth::user()->role == 2) {
            $dec = decrypt($data);
            $data = $dec;
            $name = Laboratorium::whereId($data)->value('nama');
        } else {
            $data = $this->lab;
            $name = Laboratorium::whereId($this->lab)->value('nama');
        }
        $peminjaman = Peminjaman::where('status', 4)->get();
        if ($peminjaman->IsNotEmpty()) {
            return Excel::download(new PeminjamanExport($data, $name), 'Data Peminjaman' . '-' . $name . '-' . date('Y-m-d') . '.xlsx');
        } else {
            return redirect()->back()->with('info', 'Belum terdapat peminjaman selesai!.');
        }
    }

    // Frontend
    public function checkout(Request $request)
    {
        $id_cart = $request->ckd_chld;
        $user_id = Auth::user()->id;
        $peminjaman = Peminjaman::whereIn('id', $id_cart)->get();
        $jumlah = Peminjaman::whereIn('id', $id_cart)->pluck('jumlah');
        $barang_id = Peminjaman::whereIn('id', $id_cart)->pluck('barang_id');
        $stok = Barang::whereIn('id', $barang_id)->pluck('stock');
        $nama = Barang::whereIn('id', $barang_id)->pluck('nama');
        $id_peminjaman = Peminjaman::max('id');
        $date = Date('ymd');
        $id = $id_peminjaman + 1;

        $cek = Peminjaman::where('user_id', Auth::user()->id)
            ->whereBetween('status', [0, 3])
            ->whereIn('barang_id', $barang_id)
            ->groupBy('barang_id')
            ->selectRaw('sum(jumlah) as sum')
            ->pluck('sum');

        // $kode_peminjaman = $user_id . substr(str_shuffle("0123456789"), 0, 8)
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
            if ($stok[$index] - $jml < 0 || $stok[$index] == 0) {
                return redirect()->back()->with('errr', "Stok $nama[$index] tidak mencukupi...!!");
            }

            if ($cek->IsnotEmpty()) {
                $cekJml = $cek[$index];
                if ($cekJml + $jml >= $stok[$index]) {
                    return redirect()->back()->with('errr', "Stok $nama[$index] tidak mencukupi, Karena anda sudah mengajukan $cekJml Unit...!!");
                }
            }
        }

        // cek surat
        $surat = Surat::where('user_id', $user_id)->first();
        if ($surat) {
            return redirect()->back()->with('errr', "Pengajuan Gagal, Anda membuat surat bebas lab..!!!");
        }

        // // // dd($keranjang_name);
        // foreach ($keranjang as $data) {

        //     $peminjaman = Peminjaman::create([
        // 'kode_peminjaman'   => "TK-" . $user_id . $date . $id,
        //         // 'nama_keranjang'    => $nama_keranjang,
        //         'user_id'           => $user_id,
        //         'barang_id'         => $data->barang_id,
        //         'tgl_start'         => $request->tgl_start,
        //         'tgl_end'           => $request->tgl_end,
        //         'jumlah'            => $data->jumlah,
        //         'alasan'            => $request->alasan,
        //         'status'            => 0,
        //     ]);
        // }
        // foreach ($id_cart as $id) {
        //     Keranjang::where('id', $id)->update(['status' => 1]);
        // }

        foreach ($peminjaman as $data) {
            $peminjaman = Peminjaman::whereId($data->id)->update([
                'kode_peminjaman'   => "TK-" . $user_id . $date . $id,
                // 'nama_keranjang'    => $nama_keranjang,
                'tgl_start'         => $request->tgl_start,
                'tgl_end'           => $request->tgl_end,
                'alasan'            => $request->alasan,
                'status'            => 0,
            ]);
        }

        if ($peminjaman) {
            return redirect()->route('daftar.pinjaman')->with('success', 'Pengajuan Berhasil ditambah!.');
        } else {
            return redirect()->route('daftar.pinjaman')->with('error', 'Gagal ditambah!.');
        }
    }

    public function peminjamanDetailFrontend($id, Request $request)
    {
        $id = decrypt($id);
        $user_id = Auth::user()->id;
        $peminjaman = Peminjaman::where('user_id', $user_id)
            ->where('kode_peminjaman', $id)
            ->orderBy('id', 'DESC')
            ->paginate(5);
        $detail = Peminjaman::where('user_id', $user_id)
            ->where('kode_peminjaman', $id)
            ->first();
        return view('frontend.peminjaman-detail', compact('peminjaman', 'detail'));
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $user_id = Auth::user()->id;
        $peminjaman = Peminjaman::with('barang')
            ->where('user_id', $user_id)
            ->where('kode_peminjaman', $id)
            ->first();
        return view('frontend.edit-form', compact('peminjaman'));
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

    // Print Surat Peminjaman
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
            //where > 1
            ->whereBetween('status', [2, 4])
            ->get();
        $detail = $peminjaman->first();
        // $nama_keranjang = strtoupper($detail->nama_keranjang);
        $pdf = PDF::loadview('frontend.surat-peminjaman', compact('peminjaman', 'name', 'nim', 'alamat', 'detail'));
        // return view('frontend.surat', ['peminjaman' => $peminjaman, 'name' => $name, 'nim' => $nim, 'alamat' => $alamat]);

        return $pdf->download("Surat Peminjaman" . "_" . $detail->kode_peminjaman . "_" . $name . '_' . $nim . '.pdf');
    }

    // Request Pengembalian
    public function kembalikan(Request $request)
    {
        $user_id = Auth::user()->id;
        $kode = $request->pem_id;
        Peminjaman::where('kode_peminjaman', $kode)
            ->where('user_id', $user_id)
            ->where('status', 1)
            ->delete();
        $peminjaman = Peminjaman::where('kode_peminjaman', $kode)
            ->where('user_id', $user_id)
            ->update(['status' => 3]);
        if ($peminjaman) {
            return redirect()->back()->with('success', 'Pengajuan Berhasil di Lakukan!.');
        } else {
            return redirect()->back()->with('error', 'Gagal diperbarui');
        }
    }

    public function suratBebas()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        return view('frontend.surat', compact('user'));
    }
}
