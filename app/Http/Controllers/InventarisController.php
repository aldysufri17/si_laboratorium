<?php

namespace App\Http\Controllers;

use App\Exports\InventarisExport;
use App\Models\Barang;
use App\Models\Inventaris;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class InventarisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role_id == 2) {
            $inventaris = DB::table('inventaris')
                ->leftJoin("barang", "barang.id", "=", "inventaris.barang_id")
                ->select('inventaris.kategori_lab', DB::raw('count(*) as total'))
                ->where('inventaris.status', '==', 2)
                ->groupBy('inventaris.kategori_lab')
                ->orderBy('inventaris.created_at', 'desc')
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
            $inventaris = Inventaris::with('barang')
                ->where('kategori_lab', 1)
                ->where('kategori_lab', $kategori_lab)
                ->where('status', 2)
                ->paginate(8);
        }

        return view('backend.inventaris.index', compact('inventaris'));
    }

    public function adminInventaris($data)
    {
        $inventaris = DB::table('inventaris')
            ->leftJoin("barang", "barang.id", "=", "inventaris.barang_id")
            ->where('inventaris.kategori_lab', $data)
            ->orderBy('inventaris.created_at', 'desc')
            ->paginate(10);
        return view('backend.inventaris.admin-inventaris', ['inventaris' => $inventaris]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            ->whereNotIn('id', $inventaris)
            ->get();
        return view('backend.inventaris.add', compact('barang'));
        // dd($barang);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        $request->validate([
            'kode1' => 'required',
            'kode2' => 'required',
            'kode3' => 'required',
            'kode4' => 'required',
            'barang' => 'required',
        ]);

        $inventaris = Inventaris::create([
            'barang_id'         => $request->barang,
            'kode_inventaris'   => $request->kode1 . '.' . $request->kode2 . '.' . $request->kode3 . '.' . $request->kode4,
            'kode_mutasi'       => 0,
            'status'            => 2,
            'deskripsi'         => 'Created',
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


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventaris  $inventaris
     * @return \Illuminate\Http\Response
     */
    public function show(Inventaris $inventaris)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventaris  $inventaris
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventaris $inventaris, $id)
    {
        $inventaris = Inventaris::whereId($id)->first();
        return view('backend.inventaris.edit', compact('inventaris'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventaris  $inventaris
     * @return \Illuminate\Http\Response
     */
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
        $jml_stok = $request->stock + $request->jumlah;
        $jml_rusak = $request->jml_rusak ? $request->jml_rusak : 0;
        $id_brg = $request->id_brg;
        if ($request->status == 1) {
            $barang = Barang::whereId($id_brg)->update(['stock' => $jml_stok]);
            // Inventaris
            $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            Inventaris::create([
                'barang_id'         => $id_brg,
                'status'            => 1,
                'deskripsi'         => 'Masuk',
                'kode_inventaris'   => $request->kode_inventaris,
                'kode_mutasi'       => 'IN' . $random,
                'masuk'             => $request->stock,
                'kategori_lab'      => $kategori_lab,
                'keluar'            => 0,
                'total'             => $jml_stok,
            ]);
        } else {
            $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            if ($request->stock < $request->jumlah) {
                return redirect()->route('inventaris.index')->with('warning', 'Jumlah Stok Kurang!.');
            }

            $barang = Barang::whereId($id_brg)->update([
                'stock'     => $request->stock - $request->jumlah,
                'jml_rusak' => $jml_rusak + $request->jumlah
            ]);

            Inventaris::create([
                'barang_id'         => $id_brg,
                'status'            => 0,
                'deskripsi'         => 'Rusak',
                'kode_inventaris'   => $request->kode_inventaris,
                'kode_mutasi'       => 'OUT' . $random,
                'masuk'             => 0,
                'kategori_lab'      => $kategori_lab,
                'keluar'            => $request->jumlah,
                'total'             => $request->stock - $request->jumlah,
            ]);
        }
        if ($barang) {
            return redirect()->route('inventaris.index')->with('success', 'Inventaris Berhasil diperbarui!.');
        } else {
            return redirect()->route('inventaris.index')->with('error', 'Inventaris Gagal diperbarui!.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventaris  $inventaris
     * @return \Illuminate\Http\Response
     */
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
            $inventaris = Inventaris::with('barang')
                ->where('kategori_lab', $kategori_lab)
                ->where('status', '!=', 2)
                ->orderBy('created_at', 'desc')
                ->paginate(8);
        }
        return view('backend.inventaris.mutasi', ['inventaris' => $inventaris]);
    }

    public function inventarisPdf($id)
    {
        if (Auth::user()->role_id == 3) {
            $name = "Laboratorium Sistem Tertanam dan Robotika";
        } elseif (Auth::user()->role_id == 4) {
            $name = "Laboratorium Rekayasa Perangkat Lunak";
        } elseif (Auth::user()->role_id == 5) {
            $name = "Laboratorium Jaringan dan Keamanan Komputer";
        } elseif (Auth::user()->role_id == 6) {
            $name = "Laboratorium Multimedia";
        }
        $inventaris = Inventaris::where('status', 2)->get();
        // return view('backend.inventaris.pdf_inventaris', compact('name', 'inventaris'));
        $pdf = Pdf::loadview('backend.inventaris.pdf_inventaris', compact('name', 'inventaris'));

        return $pdf->download("Inventaris Data" . "_" . $name . '_' . date('d-m-Y') . '.pdf');
    }
}
