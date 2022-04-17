<?php

namespace App\Http\Controllers;

use App\Exports\InventarisExport;
use App\Models\Barang;
use App\Models\Inventaris;
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
            $inventaris = DB::table('inventaris')
                ->leftJoin("barang", "barang.id", "=", "inventaris.barang_id")
                ->where('inventaris.kategori_lab', $kategori_lab)
                ->orderBy('inventaris.created_at', 'desc')
                ->paginate(8);
        }
        return view('backend.inventaris.index', ['inventaris' => $inventaris]);
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
        $barang = Barang::where('kategori_lab', $kategori_lab)->get();
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
            'barang' => 'required',
            'status' => 'required',
            'jumlah' => 'required',
        ]);

        $data = [
            'id'                => substr(str_shuffle("0123456789"), 0, 8),
            'barang_id'         => $request->barang,
            'status'            => $request->status,
            'deskripsi'         => $request->deskripsi,
            'kode_inventaris'   => 0,
            'kategori_lab'          => $kategori_lab,
            'masuk'             => 0,
            'keluar'            => 0,
            'total'             => 0,
        ];
        $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
        $sisa = Barang::where('id', $request->barang)->first();
        $total = $request->jumlah;
        if ($request->status == 1) {
            $data['kode_inventaris'] = 'IN' . $random;
            $data['masuk'] = $total;
            $data['keluar'] = 0;
            $data['total'] = $sisa->stock + $total;
            Barang::whereid($request->barang)->update(['stock' => $sisa->stock + $total]);
        } else {
            $data['kode_inventaris'] = 'OUT' . $random;
            $data['masuk'] = 0;
            $data['keluar'] = $total;
            if ($request->status == 2) {
                Barang::whereid($request->barang)->update(['jml_rusak' => $sisa->jml_rusak + $total]);
                $data['deskripsi'] = "Rusak" . " " . $request->deskripsi;
            }
            if ($sisa->stock - $total < 0) {
                return redirect()->route('inventaris.index')->with('warning', 'Stock Tidak Boleh Kurang dari 0');
            } else {
                $data['total'] = $sisa->stock - $total;
                Barang::whereid($request->barang)->update(['stock' => $sisa->stock - $total]);
            }
        }

        $inventaris = Inventaris::create($data);
        if ($inventaris) {
            return redirect()->route('inventaris.index')->with('success', 'Inventaris Berhasil diperbarui!.');
        } else {
            return redirect()->route('inventaris.index')->with('error', 'Inventaris Gagal diperbarui!.');
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
    public function edit(Inventaris $inventaris)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventaris  $inventaris
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventaris $inventaris)
    {
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
}
