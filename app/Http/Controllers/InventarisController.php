<?php

namespace App\Http\Controllers;

use App\Exports\InventarisExport;
use App\Exports\MutasiExport;
use App\Models\Barang;
use App\Models\Inventaris;
use App\Models\Laboratorium;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class InventarisController extends Controller
{
    protected $lab;
    protected $dataIn;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->lab = Auth::user()->post;
            return $next($request);
        });
    }

    public function index()
    {
        if (Auth::user()->role == 2) {
            $inventaris = Laboratorium::all();
        } else {
            if (request()->start_date || request()->end_date) {
                $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
                $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
                $inventaris = Inventaris::with('barang')
                    ->whereHas('barang', function ($q) {
                        $q->where('laboratorium_id', $this->lab);
                    })
                    ->whereHas('barang', function ($q) {
                        $q->where('pengadaan_id', 1);
                    })
                    ->orderBy('created_at', 'DESC')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->where('status', 2)
                    ->get();
            } else {
                $inventaris = Inventaris::whereHas('barang', function ($q) {
                    $q->where('laboratorium_id', $this->lab);
                })
                    ->whereHas('barang', function ($q) {
                        $q->where('pengadaan_id', 1);
                    })
                    ->where('status', 2)
                    ->orderBy('created_at', 'DESC')
                    ->get();
            }
        }

        return view('backend.inventaris.index', compact('inventaris'));
    }

    public function adminInventaris($data)
    {
        $this->dataIn = decrypt($data);
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $inventaris = Inventaris::with('barang')
                ->whereHas('barang', function ($q) {
                    $q->where('laboratorium_id', $this->dataIn);
                })
                ->whereHas('barang', function ($q) {
                    $q->where('pengadaan_id', 1);
                })
                ->where('status', 2)
                ->orderBy('created_at', 'desc')
                ->whereBetween('created_at', [$start_date, $end_date])
                ->get();
        } else {
            $inventaris = Inventaris::with('barang')
                ->whereHas('barang', function ($q) {
                    $q->where('laboratorium_id', $this->dataIn);
                })
                ->whereHas('barang', function ($q) {
                    $q->where('pengadaan_id', 1);
                })
                ->where('status', 2)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('backend.inventaris.admin-inventaris', compact('inventaris'));
    }

    public function edit($id)
    {
        $inventaris = Inventaris::whereId($id)->first();
        return view('backend.inventaris.edit', compact('inventaris'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'kode_inventaris'         => 'required|unique:inventaris,kode_inventaris,' . $id,
        ]);
        Inventaris::whereId($id)->update([
            'kode_inventaris' => $request->kode_inventaris,
            'keterangan' => $request->keterangan
        ]);
        return redirect()->route('inventaris.index')->with('success', 'Barang berhasil ditambah!.');
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
        return Excel::download(new InventarisExport($data, $name), 'Data Inventaris' . '-' . $name . '-' . date('Y-m-d') . '.xlsx');
    }

    public function select(Request $request)
    {
        $barang_id = $request->select;

        $id = Inventaris::where('barang_id', $barang_id)->where('status', 2)->value('id');
        $stock = Inventaris::whereId($id)->value('total_inventaris');
        $rusak = Barang::where('id', $barang_id)->value('jml_rusak');
        return response()->json(
            [
                'id' => $id,
                'stock' => $stock,
                'rusak' => $rusak,
            ]
        );
    }

    public function mutasi()
    {
        if (Auth::user()->role == 2) {
            $inventaris = Laboratorium::all();
        } else {
            if (request()->start_date || request()->end_date) {
                $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
                $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
                $inventaris = Inventaris::with('barang')
                    ->whereHas('barang', function ($q) {
                        $q->where('laboratorium_id', $this->lab);
                    })
                    ->where('status', '!=', 2)
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->get();
            } else {
                $inventaris = Inventaris::whereHas('barang', function ($q) {
                    $q->where('laboratorium_id', $this->lab);
                })
                    ->where('status', '!=', 2)
                    ->get();
            }
        }
        return view('backend.inventaris.mutasi', compact('inventaris'));
    }

    public function adminMutasi($data)
    {
        $dataIn = decrypt($data);
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $inventaris = Inventaris::with('barang')
                ->whereHas('barang', function ($q) {
                    $q->where('laboratorium_id', $this->lab);
                })
                ->where('status', '!=', 2)
                ->orderBy('id', 'DESC')
                ->whereBetween('created_at', [$start_date, $end_date])
                ->get();
        } else {
            $inventaris = Inventaris::with('barang')
                ->whereHas('barang', function ($q) {
                    $q->where('laboratorium_id', $this->dataIn);
                })
                ->where('status', '!=', 2)
                ->orderBy('id', 'DESC')
                ->get();
        }
        return view('backend.inventaris.admin-mutasi', compact('inventaris'));
    }

    public function inventarisPdf($data)
    {
        if (Auth::user()->role == 2) {
            $data = decrypt($data);
            $laboratorium_id = $data;
            $name = Laboratorium::whereId($data)->value('nama');
        } else {
            $laboratorium_id = $this->lab;
            $name = Laboratorium::whereId($this->lab)->value('nama');
        }
        $inventaris = Inventaris::where('status', 2)->where('laboratorium_id', $laboratorium_id)->get();
        // return view('backend.inventaris.pdf_inventaris', compact('name', 'inventaris'));
        $pdf = Pdf::loadview('backend.inventaris.pdf_inventaris', compact('name', 'inventaris'));

        return $pdf->download("Inventaris Data" . "_" . $name . '_' . date('d-m-Y') . '.pdf');
    }

    public function mutasiExport($data, $status)
    {
        if ($status == 0) {
            $sts = 'Barang Keluar';
        } elseif ($status == 1) {
            $sts = 'Barang Masuk';
        } else {
            $sts = 'Semua Barang';
        }
        if (Auth::user()->role == 2) {
            $dec = decrypt($data);
            $data = $dec;
            $name = Laboratorium::whereId($data)->value('nama');
        } else {
            $data = $this->lab;
            $name = Laboratorium::whereId($this->lab)->value('nama');
        }
        return Excel::download(new MutasiExport($data, $status, $name), 'Data Mutasi' . '-' . $sts . '-' . $name . '-' . date('Y-m-d') . '.xlsx');
    }

    public function mutasiPdf($data, $status)
    {
        if ($status == 0) {
            $sts = 'Barang Keluar';
        } elseif ($status == 1) {
            $sts = 'Barang Masuk';
        } else {
            $sts = 'Semua Barang';
        }

        if (Auth::user()->role == 2) {
            $data = decrypt($data);
            $laboratorium_id = $data;
            $name = Laboratorium::whereId($data)->value('nama');
        } else {
            $laboratorium_id = $this->lab;
            $name = Laboratorium::whereId($this->lab)->value('nama');
        }

        if ($status < 2) {
            $inventaris = Inventaris::where('status', $status)->whereHas('barang', function ($q) {
                $lab = Auth::user()->post;
                $q->where('laboratorium_id', $lab);
            })->get();
        } else {
            $inventaris = Inventaris::where('status', '<', 2)->whereHas('barang', function ($q) {
                $lab = Auth::user()->post;
                $q->where('laboratorium_id', $lab);
            })->get();
        }
        // return view('backend.inventaris.pdf_inventaris', compact('name', 'inventaris'));
        $pdf = Pdf::loadview('backend.inventaris.pdf_mutasi', compact('name', 'inventaris'));

        return $pdf->download("Data Mutasi" . '-' . $sts . "_" . $name . '_' . date('d-m-Y') . '.pdf');
    }
}
