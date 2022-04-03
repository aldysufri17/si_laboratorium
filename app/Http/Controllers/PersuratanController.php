<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;

class PersuratanController extends Controller
{
    public function konfirmasi()
    {
        $surat = Surat::with('user')->where('status', 0)->paginate(5);
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
}
