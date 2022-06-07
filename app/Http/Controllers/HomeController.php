<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Keranjang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{

    public function credit()
    {
        return view('frontend.creadit');
    }

    public function index(Request $request)
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            // Disetujui
            $peminjaman = Peminjaman::where('user_id', $user_id)->where('status', 2)->get();
            if ($peminjaman) {
                $request->session()->flash('in', "berhasil disetujui !!");
            }
            // Ditolak
            $tolak = Peminjaman::where('user_id', $user_id)->where('status', 1)->get();
            if ($tolak) {
                $pesan = Peminjaman::where('user_id', $user_id)->where('status', 1)->value('pesan');
                $request->session()->flash('tolak', "ditolak, $pesan !!");
            }
            // Telat
            $telat = Peminjaman::where('user_id', $user_id)->where('tgl_end', '<', date('Y-m-d'))->where('status', 2)->get();
            if ($telat) {
                $request->session()->flash('telat', "Telat");
            }
            // dd($telat);
            return view('frontend.home', compact('peminjaman'), ['telat' => $telat, 'tolak' => $tolak]);
        }
        return view('frontend.home');
    }

    public function search(Request $request)
    {
        if ($request->kategori_lab == 1 || $request->kategori_lab == "") {
            $lab = "Sistem Tertanam dan Robotika";
        } elseif ($request->kategori_lab == 2) {
            $lab = "Rekayasa Perangkat Lunak";
        } elseif ($request->kategori_lab == 3) {
            $lab = "Jaringan dan Keamanan Komputer";
        } elseif ($request->kategori_lab == 4) {
            $lab = "Multimedia";
        }

        if (Auth::check()) {
            $data = Keranjang::where('user_id', Auth::user()->id)->pluck('barang_id');
        }
        if ($request->kategori_lab) {
            if (Auth::check()) {
                $barang = Barang::where('show', 1)
                    ->where('kategori_lab', $request->kategori_lab)
                    ->whereNotIn('id', $data)
                    ->latest();
                // dd($barang);
            } else {
                $barang = Barang::where('show', 1)
                    ->where('kategori_lab', $request->kategori_lab)
                    ->latest();
            }

            if ($request->search) {
                $barang->where('nama', 'like', '%' . $request->search . '%');
            }
        } else {
            if (Auth::check()) {
                $barang = Barang::where('show', 1)
                    ->where('kategori_lab', 1)
                    ->whereNotIn('id', $data)
                    ->latest();
            } else {
                $barang = Barang::where('show', 1)
                    ->where('kategori_lab', 1)
                    ->latest();
            }
        }

        return view('frontend.search', ['barang' => $barang->paginate(7), 'lab' => $lab]);
    }

    public function detailBarang($id)
    {
        $barang = Barang::whereId($id)->first();
        return view('frontend.detail-barang', compact('barang'));
    }

    public function daftarPeminjaman(Request $request)
    {
        $user_id = Auth::user()->id;
        $peminjaman = Peminjaman::with('barang')
            ->where('user_id',  $user_id)
            ->Where('status', '<', 4)
            ->select('kode_peminjaman', DB::raw('count(*) as total'))
            ->groupBy('kode_peminjaman')
            ->paginate(7);
        $riwayat = Peminjaman::with('barang')
            ->where('user_id',  $user_id)
            ->Where('status',  4)
            ->select('created_at',  'kode_peminjaman', 'updated_at', DB::raw('count(*) as total'))
            ->groupBy('created_at',  'kode_peminjaman', 'updated_at')
            ->paginate(7);
        // Disetujui
        $setujui = Peminjaman::where('user_id', $user_id)->where('status', 2)->get();
        if ($setujui) {
            $request->session()->flash('in', "berhasil disetujui !!");
        }
        // Ditolak
        $tolak = Peminjaman::where('user_id', $user_id)->where('status', 1)->get();
        if ($tolak) {
            $pesan = Peminjaman::where('user_id', $user_id)->where('status', 1)->value('pesan');
            $request->session()->flash('tolak', "ditolak, $pesan !!");
        }
        // Telat
        $telat = Peminjaman::where('user_id', $user_id)->where('tgl_end', '<', date('Y-m-d'))->where('status', 2)->get();
        if ($telat) {
            $request->session()->flash('telat', "Telat");
        }
        return view('frontend.daftar-peminjaman', compact('peminjaman', 'riwayat', 'setujui', 'tolak', 'telat'));
    }

    public function langkahPeminjaman()
    {
        return view('frontend.langkah-peminjaman');
    }

    public function inventaris()
    {
        $barang = Barang::with('satuan', 'kategori')->where('show', 1)->paginate(8);;
        return view('frontend.inventaris', compact('barang'));
    }

    public function keranjangDetail($id, Request $request)
    {
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

    public function riwayatDetail(Request $request)
    {
        $kode = $request->kode;
        $output = "";
        $user_id = Auth::user()->id;
        $peminjaman = Peminjaman::where('kode_peminjaman', $kode)
            ->where('user_id', $user_id)
            ->get();
        foreach ($peminjaman as $data) {
            $output .= '<tr>' .
                '<td>' . $data->barang->kode_barang . '</td>' .
                '<td>' . $data->barang->nama . "-" . $data->barang->tipe . '</td>' .
                '<td>' . $data->jumlah . $data->barang->satuan->nama_satuan . '</td>' .
                '</tr>';
        }
        // asset('images/empty.jpg')
        return Response($output);
    }
}
