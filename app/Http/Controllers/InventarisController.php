<?php

namespace App\Http\Controllers;

use App\Exports\InventarisExport;
use App\Exports\MutasiExport;
use App\Models\Barang;
use App\Models\Inventaris;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class InventarisController extends Controller
{
    public function index()
    {
        if (Auth::user()->role_id == 2) {

            $inventaris = Inventaris::with('barang')
                ->select('kategori_lab', DB::raw('count(*) as total'))
                ->where('status', 2)
                ->groupBy('kategori_lab')
                ->orderBy('created_at', 'desc')
                ->get();
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

            if (request()->start_date || request()->end_date) {
                $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
                $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
                $inventaris = Inventaris::with('barang')
                    ->where('kategori_lab', $kategori_lab)
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->where('status', 2)
                    ->get();
            } else {
                $inventaris = Inventaris::with('barang')
                    ->where('kategori_lab', $kategori_lab)
                    ->where('status', 2)
                    ->get();
            }
        }

        return view('backend.inventaris.index', compact('inventaris'));
    }

    public function adminInventaris($data)
    {
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $inventaris = Inventaris::with('barang')
                ->where('kategori_lab', $data)
                ->where('status', 2)
                ->orderBy('created_at', 'desc')
                ->whereBetween('created_at', [$start_date, $end_date])
                ->get();
        } else {
            $inventaris = Inventaris::with('barang')
                ->where('kategori_lab', $data)
                ->where('status', 2)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('backend.inventaris.admin-inventaris', compact('inventaris'));
    }

    public function add($data)
    {
        if ($data == 3) {
            $kategori_lab = 1;
        } elseif ($data == 4) {
            $kategori_lab = 2;
        } elseif ($data == 5) {
            $kategori_lab = 3;
        } elseif ($data == 6) {
            $kategori_lab = 4;
        }
        $inventaris = Inventaris::where('kategori_lab', $kategori_lab)->where('status', 2)->pluck('barang_id');
        $barang = Barang::where('kategori_lab', $kategori_lab)
            ->where('pengadaan_id', 1)
            ->whereNotIn('id', $inventaris)
            ->get();
        return view('backend.inventaris.add', compact('barang'));
    }

    public function store(Request $request)
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

        $request->validate(
            [
                'kode_inventaris' => 'required|unique:inventaris',
                'barang' => 'required',
                'stok' => 'required',
            ],
            [
                'unique' => 'Kode sudah digunakan',
                'required' => 'Masukan Tidak boleh kosong.!!'
            ]
        );
        $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
        $inventaris = Inventaris::create([
            'barang_id'         => $request->barang,
            'kode_inventaris'   => $request->kode_inventaris,
            'kode_mutasi'       => 'CR' . $random,
            'status'            => 2,
            'deskripsi'         => 'Created',
            'keterangan'        => $request->keterangan,
            'stok'              => $request->stok,
            'kategori_lab'      => $kategori_lab,
            'masuk'             => 0,
            'keluar'            => 0,
            'total'             => 0,
        ]);

        if ($inventaris) {
            return redirect()->route('inventaris.index')->with('success', 'Inventaris Berhasil dibuat!.');
        } else {
            return redirect()->route('inventaris.index')->with('error', 'Inventaris Gagal dibuat!.');
        }
    }


    public function edit(Inventaris $inventaris, $id)
    {
        $inventaris = Inventaris::whereId($id)->first();
        return view('backend.inventaris.edit', compact('inventaris'));
    }

    public function update(Request $request, Inventaris $inventaris)
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
        $total_brg = $request->stok_brg + $request->jumlah;
        $jml_rusak = $request->jml_rusak;
        $id_brg = $request->id_brg;
        $stok_inventaris = $request->stok_inventaris;
        $id_inven = $request->id_inventaris;
        if ($request->status == 1) {
            Barang::whereId($id_brg)->update(['stock' => $total_brg]);
            $inventaris = Inventaris::whereId($id_inven)->update(['stok' => $stok_inventaris + $request->jumlah]);
            // mutasi dan ineventaris
            $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            Inventaris::create([
                'barang_id'         => $id_brg,
                'status'            => 1,
                'deskripsi'         => 'Masuk',
                'keterangan'        => $request->keterangan,
                'kode_inventaris'   => 'IN' . $random,
                'kode_mutasi'       => 'IN' . $random,
                'masuk'             => $request->jumlah,
                'kategori_lab'      => $kategori_lab,
                'keluar'            => 0,
                'total'             => $total_brg,
                'stok'              => $stok_inventaris + $request->jumlah,
            ]);
        } else {
            $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            if ($request->stok_brg < $request->jumlah || $stok_inventaris < $request->jumlah) {
                return redirect()->route('inventaris.index')->with('warning', 'Jumlah Stok Kurang!.');
            }

            Barang::whereId($id_brg)->update([
                'stock'     => $request->stok_brg - $request->jumlah,
                'jml_rusak' => $jml_rusak + $request->jumlah
            ]);
            $inventaris = Inventaris::whereId($id_inven)->update(['stok' => $stok_inventaris - $request->jumlah]);

            // mutasi dan ineventaris
            Inventaris::create([
                'barang_id'         => $id_brg,
                'status'            => 0,
                'deskripsi'         => 'Rusak',
                'keterangan'        => $request->keterangan,
                'kode_inventaris'   => 'OUT' . $random,
                'kode_mutasi'       => 'OUT' . $random,
                'masuk'             => 0,
                'kategori_lab'      => $kategori_lab,
                'keluar'            => $request->jumlah,
                'total'             => $request->stok_brg - $request->jumlah,
                'stok'              => $stok_inventaris - $request->jumlah,
            ]);
        }
        if ($inventaris) {
            return redirect()->route('inventaris.index')->with('success', 'Inventaris Berhasil diperbarui!.');
        } else {
            return redirect()->route('inventaris.index')->with('error', 'Inventaris Gagal diperbarui!.');
        }
    }

    public function destroy(Inventaris $inventaris, Request $request)
    {
        $inventaris = Inventaris::whereId($request->delete_id)->delete();
        if ($inventaris) {
            return redirect()->back()->with('success', 'Inventaris Berhasil dihapus!.');
        } else {
            return redirect()->back()->with('error', 'Inventaris Gagal dihapus!.');
        }
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
        return Excel::download(new InventarisExport($data), 'Data Inventaris' . '-' . $name . '-' . date('Y-m-d') . '.xlsx');
    }

    public function select(Request $request)
    {
        $barang_id = $request->select;

        $stock = Barang::where('id', $barang_id)->value('stock');
        $rusak = Barang::where('id', $barang_id)->value('jml_rusak');
        return response()->json(
            [
                'stock' => $stock,
                'rusak' => $rusak,
            ]
        );
    }

    public function mutasi()
    {
        if (Auth::user()->role_id == 2) {
            $inventaris = Inventaris::with('barang')
                ->select('kategori_lab', DB::raw('count(*) as total'))
                ->where('status', '!=', 2)
                ->groupBy('kategori_lab')
                ->orderBy('created_at', 'desc')
                ->paginate(8);
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
            if (request()->start_date || request()->end_date) {
                $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
                $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
                $inventaris = Inventaris::with('barang')
                    ->where('kategori_lab', $kategori_lab)
                    ->where('status', '!=', 2)
                    ->orderBy('id', 'DESC')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->get();
            } else {
                $inventaris = Inventaris::with('barang')
                    ->where('kategori_lab', $kategori_lab)
                    ->where('status', '!=', 2)
                    ->orderBy('id', 'DESC')
                    ->get();
            }
        }
        return view('backend.inventaris.mutasi', ['inventaris' => $inventaris]);
    }

    public function adminMutasi($data)
    {
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $inventaris = Inventaris::with('barang')
                ->where('kategori_lab', $data)
                ->where('status', '!=', 2)
                ->orderBy('id', 'DESC')
                ->whereBetween('created_at', [$start_date, $end_date])
                ->get();
        } else {
            $inventaris = Inventaris::with('barang')
                ->where('kategori_lab', $data)
                ->where('status', '!=', 2)
                ->orderBy('id', 'DESC')
                ->get();
        }
        return view('backend.inventaris.admin-mutasi', compact('inventaris'));
    }

    public function inventarisPdf($data)
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
        $inventaris = Inventaris::where('status', 2)->where('kategori_lab', $kategori_lab)->get();
        // return view('backend.inventaris.pdf_inventaris', compact('name', 'inventaris'));
        $pdf = Pdf::loadview('backend.inventaris.pdf_inventaris', compact('name', 'inventaris'));

        return $pdf->download("Inventaris Data" . "_" . $name . '_' . date('d-m-Y') . '.pdf');
    }

    public function mutasiExport($data, $status)
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

        if ($status == 0) {
            $sts = 'Barang Keluar';
        } elseif ($status == 1) {
            $sts = 'Barang Masuk';
        } else {
            $sts = 'Semua Barang';
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
        return Excel::download(new MutasiExport($data, $status), 'Data Mutasi' . '-' . $sts . '-' . $name . '-' . date('Y-m-d') . '.xlsx');
    }

    public function mutasiPdf($data, $status)
    {
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

        if ($status == 0) {
            $sts = 'Barang Keluar';
        } elseif ($status == 1) {
            $sts = 'Barang Masuk';
        } else {
            $sts = 'Semua Barang';
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

        if ($status < 2) {
            $inventaris = Inventaris::where('status', $status)->where('kategori_lab', $kategori_lab)->get();
        } else {
            $inventaris = Inventaris::where('status', '<', 2)->where('kategori_lab', $kategori_lab)->get();
        }
        // return view('backend.inventaris.pdf_inventaris', compact('name', 'inventaris'));
        $pdf = Pdf::loadview('backend.inventaris.pdf_mutasi', compact('name', 'inventaris'));

        return $pdf->download("Data Mutasi" . '-' . $sts . "_" . $name . '_' . date('d-m-Y') . '.pdf');
    }
}
