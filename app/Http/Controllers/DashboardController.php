<?php

namespace App\Http\Controllers;

use App\Models\Barang;
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


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // notifikasi
        if (Auth::user()->role_id > 2) {
            if (Auth::user()->role_id == 3) {
                $kategori_lab = 1;
            } elseif (Auth::user()->role_id == 4) {
                $kategori_lab = 2;
            } elseif (Auth::user()->role_id == 5) {
                $kategori_lab = 3;
            } elseif (Auth::user()->role_id == 6) {
                $kategori_lab = 4;
            }
            $peminjaman = Peminjaman::where('kategori_lab', $kategori_lab)
                ->where('status', 0)
                ->select('kode_peminjaman')
                ->groupBy('kode_peminjaman')
                ->get();
            $total = count($peminjaman);
            $request->session()->flash('eror', "$total Keranjang pengajuan belum disetujui !!!");
            // $telat = Peminjaman::whereBetween('status', [2, 3])->where('tgl_end', '<', date('Y-m-d'))->where('kategori_lab', $kategori_lab)->paginate(5);

            $telat = Peminjaman::whereBetween('status', [2, 3])
                ->where('tgl_end', '<', date('Y-m-d'))
                ->where('kategori_lab', $kategori_lab)
                ->select('kode_peminjaman', 'user_id', 'tgl_end')
                ->groupBy('kode_peminjaman', 'user_id', 'tgl_end')
                ->paginate(5);
            // dd($telat);
            $habis = Barang::where('stock', 0)->paginate(5);
            return view('backend.dashboard',  compact(['peminjaman', 'telat', 'habis']));
        }
        return view('backend.dashboard');
    }

    /**
     * User Profile
     * @param Nill
     * @return View Profile
     * @author Shani Singh
     */
    public function getProfile()
    {
        if (Auth::user()->role_id == 1) {
            return view('frontend.profile');
        }
        return view('backend.profile');
    }

    /**
     * Update Profile
     * @param $profileData
     * @return Boolean With Success Message
     * @author Shani Singh
     */
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

    /**
     * Change Password
     * @param Old Password, New Password, Confirm New Password
     * @return Boolean With Success Message
     * @author Shani Singh
     */
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
            if ($usercek->foto) {
                unlink('images/user/' . $usercek->foto);
            }
            $foto = $request->foto;
            $new_foto = date('Y-m-d') . "-" . Auth::user()->name . "-" . Auth::user()->nim . "." . $foto->getClientOriginalExtension();
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
            if (file_exists(public_path('images/user/ktm/' . $bb->ktm))) {
                unlink('images/user/ktm/' . $bb->ktm);
            }
            $ktm = $request->ktm;
            $new_ktm = date('Y-m-d') . "-" . Auth::user()->name . "-" . Auth::user()->nim . "." . $ktm->getClientOriginalExtension();
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
