<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    // Peminjaman
    public function index()
    {
        $peminjaman = Peminjaman::with('user', 'barang')
            ->where('status', '>=', 2)
            ->paginate(5);
        return view('backend.peminjaman.index', compact('peminjaman'));
    }

    // Konfirmasi Peminjaman
    public function peminjaman()
    {
        $peminjaman = Peminjaman::withCount('user')
            ->select('date', DB::raw('count(*) as total'))
            ->where('status', '=', 0)
            ->groupBy('date')
            ->paginate(5);
        return view('backend.peminjaman.konfirmasi.peminjaman', compact('peminjaman'));
    }

    public function konfirmasiPeminjamanDetail($data)
    {
        $peminjaman = Peminjaman::with('user', 'barang')
            ->where('date', $data)
            ->where('status', '=', 0)
            ->paginate(5);
        return view('backend.peminjaman.konfirmasi.peminjaman-detail', compact('peminjaman'));
    }

    public function konfirmasiStatus($user_id, $status, $barang_id, $jumlah)
    {
        if ($status == 2) {
            $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            $sisa = Barang::where('id', $barang_id)->first();
            $total = $sisa->stock;
            if ($total - $jumlah < 0) {
                return redirect()->back()->with('warning', 'Stock Barang tidak mencukupi!.');
            }
            $stock = Stock::create([
                'barang_id'     => $barang_id,
                'status'        => 0,
                'deskripsi'     => "Active",
                'inventaris'    => 'OUT' . $random,
                'masuk'         => 0,
                'keluar'        => $jumlah,
                'total'         => $total - $jumlah,
            ]);
            Barang::whereid($barang_id)->update(['stock' => $total - $jumlah]);
            Peminjaman::whereId($user_id)->update(['status' => $status]);
            if ($stock) {
                return redirect()->back()->with('success', 'Peminjaman Berhasil di Setujui!.');
            }
        } elseif ($status == 3) {
            $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            $sisa = Barang::where('id', $barang_id)->first();
            $total = $sisa->stock;
            $stock = Stock::create([
                'barang_id'     => $barang_id,
                'status'        => 1,
                'deskripsi'     => "Clear",
                'inventaris'    => 'IN' . $random,
                'masuk'         => $jumlah,
                'keluar'        => 0,
                'total'         => $total + $jumlah,
            ]);
            Barang::whereid($barang_id)->update(['stock' => $total + $jumlah]);
            Peminjaman::whereId($user_id)->update(['status' => $status]);
            if ($stock) {
                return redirect()->back()->with('success', 'Pengembalian Berhasil di Setujui!.');
            }
        } else {
            $peminjaman = Peminjaman::whereId($user_id)->update(['status' => $status]);
            if ($peminjaman) {
                return redirect()->back()->with('info', 'Peminjaman Berhasil di Batalkan!.');
            } else {
                return redirect()->back()->with('error', 'Gagal diperbarui');
            }
        }
    }


    // Konfirmasi Pengembalian
    public function pengembalian()
    {
        $peminjaman = Peminjaman::with('user', 'barang')
            ->where('status', 2)
            ->paginate(5);
        return view('backend.peminjaman.konfirmasi.pengembalian', compact('peminjaman'));
    }

    public function pengembalianScan()
    {
        return view('backend.peminjaman.konfirmasi.scan');
    }

    public function scan($lower)
    {
        $id = intval($lower);
        $peminjaman = Peminjaman::where('user_id', $id)->where('status', 2)->update(['status' => 3]);
        if ($peminjaman) {
            return redirect()->route('konfirmasi.pengembalian')->with('success', 'Pengembalian Berhasil!.');
        }
        return redirect()->back()->with('error', 'Pengembalian Gagal!.');
    }
}
