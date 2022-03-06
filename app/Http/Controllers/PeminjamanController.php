<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Inventaris;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;


class PeminjamanController extends Controller
{
    // Peminjaman
    public function index()
    {
        $peminjaman = Peminjaman::with('user', 'barang')
            ->where('status', '>', 2)
            ->paginate(5);
        return view('backend.transaksi.index', compact('peminjaman'));
    }

    // Konfirmasi Peminjaman
    public function pengajuan()
    {
        $peminjaman = Peminjaman::withCount('user')
            ->select('date', DB::raw('count(*) as total'))
            ->orWhere('status', 0)
            ->groupBy('date')
            ->paginate(5);
        return view('backend.transaksi.konfirmasi.pengajuan', compact('peminjaman'));
    }
    public function pengajuanDetail($data)
    {
        $peminjaman = Peminjaman::with('user', 'barang')
            ->where('date', $data)
            ->Where('status', 0)
            ->paginate(5);
        return view('backend.transaksi.konfirmasi.pengajuan-detail', compact('peminjaman'));
    }

    // Konfirmasi Peminjaman
    public function peminjaman()
    {
        $peminjaman = Peminjaman::withCount('user')
            ->select('date', DB::raw('count(*) as total'))
            ->where('status', '=', 2)
            ->groupBy('date')
            ->paginate(5);
        return view('backend.transaksi.konfirmasi.peminjaman.index', compact('peminjaman'));
    }

    public function konfirmasiPeminjamanDetail($data)
    {
        $peminjaman = Peminjaman::with('user', 'barang')
            ->where('date', $data)
            ->where('status', '=', 2)
            ->paginate(5);
        return view('backend.transaksi.konfirmasi.peminjaman.detail', compact('peminjaman'));
    }

    public function create()
    {
        $barang = Barang::all();
        $user = User::where('role_id', 3)->get();
        return view('backend.transaksi.konfirmasi.peminjaman.add', compact('barang', 'user'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required',
            'alasan' => 'required',
            'tgl_start' => 'required',
            'tgl_end' => 'required',
        ]);
        $user_id = Auth::user()->id;
        $peminjaman = Peminjaman::create([
            'user_id'   => $user_id,
            'barang_id' => $id,
            'tgl_start' => $request->tgl_start,
            'tgl_end'   => $request->tgl_end,
            'jumlah'    => $request->jumlah,
            'alasan'    => $request->alasan,
            'status'    => 0,
            'date'      => date('Y-m-d')
        ]);
        if ($peminjaman) {
            return redirect()->route('search')->with('success', 'Barang Berhasil di tambah!.');
        } else {
            return redirect()->back()->with('error', 'Gagal ditambah');
        }
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::with('barang')->whereId($id)->first();
        return view('frontend.edit-detail', compact('peminjaman'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required',
            'alasan' => 'required',
            'tgl_start' => 'required',
            'tgl_end' => 'required',
        ]);
        $peminjaman = Peminjaman::whereId($id)->update([
            'tgl_start' => $request->tgl_start,
            'tgl_end'   => $request->tgl_end,
            'jumlah'    => $request->jumlah,
            'alasan'    => $request->alasan,
        ]);
        if ($peminjaman) {
            return redirect()->route('cart')->with('success', 'Barang Berhasil di edit!.');
        } else {
            return redirect()->back()->with('error', 'Gagal ditambah');
        }
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::where('id', $id)->delete();
        if ($peminjaman) {
            return redirect()->back()->with('success', 'Barang Berhasil dihapus!.');
        } else {
            return redirect()->back()->with('error', 'Barang Gagal dihapus!.');
        }
    }


    public function konfirmasiStatus($user_id, $status, $barang_id, $jumlah)
    {
        if ($status == 3) {
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
        } elseif ($status == 4) {
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
        } elseif ($status == 2) {
            $peminjaman = Peminjaman::whereId($user_id)->update(['status' => $status]);
            if ($peminjaman) {
                return redirect()->back()->with('success', 'Pengajuan Berhasil di Setujui!.');
            } else {
                return redirect()->back()->with('error', 'Gagal diperbarui');
            }
        } else {
            $peminjaman = Peminjaman::whereId($user_id)->update(['status' => $status]);
            if ($peminjaman) {
                return redirect()->back()->with('info', 'Pengajuan Berhasil di Tolak!.');
            } else {
                return redirect()->back()->with('error', 'Gagal diperbarui');
            }
        }
    }


    // Konfirmasi Pengembalian
    public function pengembalian()
    {
        $peminjaman = Peminjaman::with('user', 'barang')
            ->where('status', 3)
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
        dd($id_peminjaman);
        // if (intval($status) == 1) {
        //     $peminjaman = Peminjaman::whereid($id_peminjaman)->where('status', 0)->update(['status' => 2]);
        // } else {
        //     $peminjaman = Peminjaman::whereid($id_peminjaman)->where('status', 2)->update(['status' => 3]);
        // }

        // if ($peminjaman) {
        //     return redirect()->back()->with('success', 'Data Berhasil di setujui!.');
        // } else {
        //     return redirect()->back()->with('error', 'Gagal disetujui');
        // }
    }

    public function print()
    {
        $user_id = Auth::user()->id;
        $name = Auth::user()->name;
        $nim = Auth::user()->nim;
        $peminjaman = Peminjaman::where('user_id', $user_id)->where('status', 2)->get();
        $pdf = PDF::loadview('frontend.surat', ['peminjaman' => $peminjaman, 'name' => $name, 'nim' => $nim,]);
        if ($peminjaman->isEmpty()) {
            return redirect()->back()->with('info', 'Pengajuan Belum disetujui!.');
        }
        return $pdf->download("Surat Peminjaman" . "_" . $name . '_' . $nim . '.pdf');
    }
}
