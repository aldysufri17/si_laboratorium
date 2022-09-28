<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Keranjang;
use App\Models\Laboratorium;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    protected $lab;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                $this->lab = Auth::user()->post;
            }
            return $next($request);
        });
    }

    public function author()
    {
        return view('frontend.author');
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

    public function daftarBarang()
    {
        return view('frontend.daftar-barang');
    }

    public function detailBarang($id)
    {
        $barang = Barang::whereId(decrypt($id))->first();
        return view('frontend.detail-barang', compact('barang'));
    }

    public function daftarPeminjaman(Request $request)
    {
        $user_id = Auth::user()->id;
        $peminjaman = Peminjaman::with('barang')
            ->where('user_id',  $user_id)
            ->WhereBetween('status', [0, 3])
            ->select('kode_peminjaman', DB::raw('count(*) as total'))
            ->groupBy('kode_peminjaman')
            ->paginate(7);
        $riwayat = Peminjaman::with('barang')
            ->where('user_id',  $user_id)
            ->Where('status',  4)
            ->select('kode_peminjaman', 'tgl_end', DB::raw('count(*) as total'))
            ->groupBy('kode_peminjaman', 'tgl_end')
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

    public function riwayatDetail(Request $request)
    {
        $kode = $request->kode;
        $output = "";
        $user = "";
        if (Auth::user()->role == 1) {
            $user_id = Auth::user()->id;
            $peminjaman = Peminjaman::where('kode_peminjaman', $kode)
                ->where('status', 4)
                ->where('user_id', $user_id)
                ->get();
        } else if (Auth::user()->role == 2) {
            $peminjaman = Peminjaman::where('kode_peminjaman', $kode)
                ->where('status', 4)
                ->get();
        } else {
            $peminjaman = Peminjaman::where('kode_peminjaman', $kode)
                ->whereHas('barang', function ($q) {
                    $q->where('laboratorium_id', $this->lab);
                })
                ->where('status', 4)
                ->get();
        }
        foreach ($peminjaman as $data) {
            $user = '<tr>' .
                '<td width="30%" class="font-weight-bold">Peminjam</td>' .
                '<td>' . ':' . " " . $data->user->name . " " . '/' . " " . $data->user->nim . '</td>' .
                '</tr>' .
                '<tr>' .
                '<td width="30%" class="font-weight-bold">Keperluan</td>' .
                '<td>' . ':' . " " . $data->alasan  . '</td>' .
                '</tr>' .
                '<tr>' .
                '<td width="30%" class="font-weight-bold">Tanggal Peminjaman</td>' .
                '<td>' . ':' . " " . $data->tgl_start  . '</td>' .
                '</tr>' .
                '<tr>' .
                '<td width="30%" class="font-weight-bold">Tanggal Pengembalian</td>' .
                '<td>' . ':' . " " . $data->tgl_end  . '</td>' .
                '</tr>' .
                '<tr>';

            if (Auth::user()->role == 2) {
                $brg = Barang::whereId($data->barang_id)->value('laboratorium_id');
                $labname = Laboratorium::whereId($brg)->value('nama');
                $output .= '<tr>' .
                    '<td>' . $labname . '</td>' .
                    '<td>' . $data->barang->kode_barang . '</td>' .
                    '<td>' . $data->barang->nama . "-" . $data->barang->tipe . '</td>' .
                    '<td>' . $data->jumlah . $data->barang->satuan->nama_satuan . '</td>' .
                    '</tr>';
            } else {
                $output .= '<tr>' .
                    '<td>' . $data->barang->kode_barang . '</td>' .
                    '<td>' . $data->barang->nama . "-" . $data->barang->tipe . '</td>' .
                    '<td>' . $data->jumlah . $data->barang->satuan->nama_satuan . '</td>' .
                    '</tr>';
            }
        }
        return response()->json([
            'output' => $output,
            'user' => $user
        ]);
    }
}
