<?php

namespace App\Http\Controllers;

use App\Exports\SuratExport;
use App\Models\Surat;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PersuratanController extends Controller
{
    public function konfirmasi()
    {
        $surat = Surat::with('user')->where('status', 0)->get();
        return view('backend.surat.konfirmasi', compact('surat'));
    }

    public function riwayat()
    {
        $surat = Surat::with('user')->where('status', 2)->paginate(5);
        return view('backend.surat.riwayat', compact('surat'));
    }

    public function create()
    {
        return view('backend.surat.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required',
            'nim'    => 'required',
            'alamat'    => 'required',
        ]);
        $pdf = PDF::loadview('frontend.surat-bebas', compact('request'));
        return $pdf->download("Surat Bebas Lab" . "_" . $request->name . '_' . $request->nim . '.pdf');
    }

    public function status($id, $status)
    {
        $persuratan = Surat::whereId($id)->update(['status' => $status]);
        if ($persuratan) {
            if ($status == 1) {
                return redirect()->route('persuratan.konfirmasi')->with('success', 'Pengajuan Berhasil dibatalkan!.');
            }
            return redirect()->route('persuratan.konfirmasi')->with('success', 'Pengajuan Berhasil disetujui!.');
        } else {
            return redirect()->route('persuratan.konfirmasi')->with('error', 'Gagal diperbarui');
        }
    }

    public function damagedExport($data)
    {
        return Excel::download(new SuratExport($data), 'Data Riwayat Surat' . '-' . date('Y-m-d') . '.xlsx');
    }

    public function damagedPdf($data)
    {
        $surat = Surat::where('status', 1)->get();
        // return view('backend.inventaris.pdf_inventaris', compact('name', 'inventaris'));
        $pdf = Pdf::loadview('backend.surat.pdf_surat', compact('surat'));

        return $pdf->download("Data Barang Rusak" . "_" . date('d-m-Y') . '.pdf');
    }
}
