<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Inventaris;
use App\Models\User;
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
        return view('backend.transaksi.index', compact('peminjaman'));
    }

    // Konfirmasi Peminjaman
    public function peminjaman()
    {
        $peminjaman = Peminjaman::withCount('user')
            ->select('date', DB::raw('count(*) as total'))
            ->where('status', '=', 0)
            ->groupBy('date')
            ->paginate(5);
        return view('backend.transaksi.konfirmasi.peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $barang = Barang::all();
        $user = User::where('role_id', 3)->get();
        return view('backend.transaksi.konfirmasi.peminjaman.add', compact('barang', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required',
            'alasan' => 'required',
            'barang' => 'required',
            'user' => 'required'
        ]);
        $peminjaman = Peminjaman::create([
            'user_id' => $request->user,
            'barang_id' => $request->barang,
            'tgl_start' => $request->tgl_start,
            'tgl_end'   => $request->tgl_end,
            'jumlah'    => $request->jumlah,
            'alasan'    => $request->alasan,
            'status'    => 0,
            'date'      => date('Y-m-d')
        ]);
        if ($peminjaman) {
            return redirect()->route('konfirmasi.peminjaman')->with('success', 'Peminjaman Berhasil ditambah!.');
        } else {
            return redirect()->back()->with('error', 'Gagal ditambah');
        }
    }

    public function konfirmasiPeminjamanDetail($data)
    {
        $peminjaman = Peminjaman::with('user', 'barang')
            ->where('date', $data)
            ->where('status', '=', 0)
            ->paginate(5);
        return view('backend.transaksi.konfirmasi.peminjaman.detail', compact('peminjaman'));
    }

    public function konfirmasiStatus($user_id, $status, $barang_id, $jumlah)
    {
        if ($status == 2) {
            $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            $sisa = Barang::where('id', $barang_id)->first();
            $total = $sisa->stock;
            if ($total - $jumlah < 0) {
                return redirect()->back()->with('warning', 'Inventaris Barang tidak mencukupi!.');
            }
            $inventaris = Inventaris::create([
                'barang_id'     => $barang_id,
                'status'        => 0,
                'deskripsi'     => "Active",
                'kode_inventaris'    => 'OUT' . $random,
                'masuk'         => 0,
                'keluar'        => $jumlah,
                'total'         => $total - $jumlah,
            ]);
            Barang::whereid($barang_id)->update(['stock' => $total - $jumlah]);
            Peminjaman::whereId($user_id)->update(['status' => $status]);
            if ($inventaris) {
                return redirect()->back()->with('success', 'Peminjaman Berhasil di Setujui!.');
            }
        } elseif ($status == 3) {
            $random = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            $sisa = Barang::where('id', $barang_id)->first();
            $total = $sisa->stock;
            $inventaris = Inventaris::create([
                'barang_id'     => $barang_id,
                'status'        => 1,
                'deskripsi'     => "Clear",
                'kode_inventaris'    => 'IN' . $random,
                'masuk'         => $jumlah,
                'keluar'        => 0,
                'total'         => $total + $jumlah,
            ]);
            Barang::whereid($barang_id)->update(['stock' => $total + $jumlah]);
            Peminjaman::whereId($user_id)->update(['status' => $status]);
            if ($inventaris) {
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
        $id_peminjaman = intval($id);
        if (intval($status) == 1) {
            $peminjaman = Peminjaman::whereid($id_peminjaman)->where('status', 0)->update(['status' => 2]);
        } else {
            $peminjaman = Peminjaman::whereid($id_peminjaman)->where('status', 2)->update(['status' => 3]);
        }

        if ($peminjaman) {
            return redirect()->back()->with('success', 'Data Berhasil di setujui!.');
        } else {
            return redirect()->back()->with('error', 'Gagal disetujui');
        }
    }
}
