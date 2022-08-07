<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Laboratorium;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public $lab;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->lab = Auth::user()->laboratorium_id;
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        // notifikasi
        if (Auth::user()->role > 2) {
            $barang = Peminjaman::whereHas('barang', function ($q) {
                $q->where('laboratorium_id', $this->lab);
            })
                ->whereBetween('status', [2, 3])
                ->groupBy('barang_id')
                ->selectRaw('barang_id, sum(jumlah) as sum')
                ->get();

            $notif = Peminjaman::whereHas('barang', function ($q) {
                $q->where('laboratorium_id', $this->lab);
            })
                ->where('status', 0)
                ->select('kode_peminjaman')
                ->groupBy('kode_peminjaman')
                ->get();
            $total = count($notif);
            $request->session()->flash('eror', "$total Pengajuan belum disetujui !!!");

            $telat = Peminjaman::whereBetween('status', [2, 3])
                ->where('tgl_end', '<', date('Y-m-d'))
                ->whereHas('barang', function ($q) {
                    $lab = Auth::user()->laboratorium_id;
                    $q->where('laboratorium_id', $lab);
                })
                ->select('kode_peminjaman', 'user_id', 'tgl_end')
                ->groupBy('kode_peminjaman', 'user_id', 'tgl_end')
                ->paginate(5);

            $habis = Barang::where('stock', 0)
                ->where('laboratorium_id', $this->lab)
                ->paginate(5);
            return view('backend.dashboard',  compact(['barang', 'habis', 'telat', 'notif']));
        }
        $laboratorium = Laboratorium::all();
        return view('backend.dashboard', compact('laboratorium'));
    }

    public function getProfile()
    {
        if (Auth::user()->role == 1) {
            return view('frontend.profile');
        }
        return view('backend.profile');
    }

    public function updateProfile(Request $request)
    {
        #Validations
        $request->validate([
            'name'    => 'required',
            'jk'    => 'required',
            'alamat'    => 'required',
            'mobile_number' => 'required|numeric|digits:10',
        ]);

        #Update Profile Data
        $user = User::whereId(auth()->user()->id)->update([
            'name' => $request->name,
            'jk' => $request->jk,
            'mobile_number' => $request->mobile_number,
            'alamat' => $request->alamat,
        ]);

        if ($user) {
            return back()->with('success', 'Profile Berhasil diubah.');
        } else {
            return redirect()->back()->with('error', 'User Gagal ditambah!.');
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        #Update Password
        $user = User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
        if ($user) {
            return back()->with('success', 'Profile Berhasil diubah.');
        } else {
            return redirect()->back()->with('error', 'User Gagal ditambah!.');
        }
    }

    public function updateFoto(Request $request, User $user)
    {
        $user_id = Auth::user()->id;
        if ($request->foto) {
            $usercek = User::whereid($user_id)->first();
            if (!file_exists(public_path() . '/images/user/' . $usercek->foto)) {
                unlink(public_path() . '/images/user/' . $usercek->foto);
            }
            $foto = $request->foto;
            $new_foto = Auth::user()->name . "-" . Auth::user()->nim . "." . $foto->getClientOriginalExtension();
            $destination = 'images/user/';
            $foto->move($destination, $new_foto);
            // Store Data
            $user_updated = User::whereId($user_id)->update([
                'foto'          => $new_foto,
            ]);
        }
        if ($user_updated) {
            return redirect()->back()->with('success', 'Foto Berhasil diperbarui!.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Foto Gagal diperbarui!.');
        }
    }

    public function updateKTM(Request $request)
    {
        $user_id = Auth::user()->id;
        if ($request->ktm) {
            $bb = User::whereid($user_id)->first();
            if (!file_exists(public_path() . '/images/user/ktm/' . $bb->ktm)) {
                unlink(public_path() . '/images/user/ktm/' . $bb->ktm);
            }
            $ktm = $request->ktm;
            $new_ktm = Auth::user()->name . "-" . Auth::user()->nim . "." . $ktm->getClientOriginalExtension();
            $destination = 'images/user/ktm/';
            $ktm->move($destination, $new_ktm);
            // Store Data
            $user_updated = User::whereId($user_id)->update([
                'ktm'          => $new_ktm,
            ]);
        } else {
            return redirect()->back()->with('warning', 'Masukkan Foto..!!.');
        }
        if ($user_updated) {
            return redirect()->back()->with('success', 'KTM Berhasil diperbarui!.');
        } else {
            return redirect()->back()->withInput()->with('error', 'KTM Gagal diperbarui!.');
        }
    }
}
