<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Keranjang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

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

    public function riwayatDetail(Request $request)
    {
        if (Auth::user()->role_id == 3) {
            $lab = 1;
        } elseif (Auth::user()->role_id == 4) {
            $lab = 2;
        } elseif (Auth::user()->role_id == 5) {
            $lab = 3;
        } elseif (Auth::user()->role_id == 6) {
            $lab = 4;
        }
        $kode = $request->kode;
        $output = "";
        $user = "";
        if (Auth::user()->role_id == 1) {
            $user_id = Auth::user()->id;
            $peminjaman = Peminjaman::where('kode_peminjaman', $kode)
                ->where('user_id', $user_id)
                ->get();
        } else if (Auth::user()->role_id == 2) {
            $peminjaman = Peminjaman::where('kode_peminjaman', $kode)
                ->get();
        } else {
            $peminjaman = Peminjaman::where('kode_peminjaman', $kode)
                ->where('kategori_lab', $lab)
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

            if (Auth::user()->role_id == 2) {

                if ($data->kategori_lab == 1) {
                    $lab = "Laboratorium Sistem Tertanam dan Robotika";
                } elseif ($data->kategori_lab == 2) {
                    $lab = "Laboratorium Rekayasa Perangkat Lunak";
                } elseif ($data->kategori_lab == 3) {
                    $lab = "Laboratorium Jaringan dan Keamanan Komputer";
                } elseif ($data->kategori_lab == 4) {
                    $lab = "Laboratorium Multimedia";
                }

                $output .= '<tr>' .
                    '<td>' . $lab . '</td>' .
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
