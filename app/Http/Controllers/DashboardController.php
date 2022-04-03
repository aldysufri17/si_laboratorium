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
                $kategori = 1;
            } elseif (Auth::user()->role_id == 4) {
                $kategori = 2;
            } elseif (Auth::user()->role_id == 5) {
                $kategori = 3;
            } elseif (Auth::user()->role_id == 6) {
                $kategori = 4;
            }
            $peminjaman = Peminjaman::where('kategori', $kategori)->where('status', 0)->get();
            $total = Peminjaman::where('kategori', $kategori)->where('status', 0)->count();
            $request->session()->flash('eror', "$total pengajuan belum disetujui !!!");
            return view('backend.dashboard',  compact(['peminjaman']));
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
                unlink(storage_path('app/public/user/' . $usercek->foto));
            }
            $foto = $request->foto;
            $new_foto = date('Y-m-d') . "-" . Auth::user()->name . "-" . Auth::user()->nim . "." . $foto->getClientOriginalExtension();
            $destination = storage_path('app/public/user');
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
            $usercek = User::whereid($user_id)->first();
            if ($usercek->ktm) {
                unlink(storage_path('app/public/user/ktm/' . $usercek->ktm));
            }
            $ktm = $request->ktm;
            $new_ktm = date('Y-m-d') . "-" . Auth::user()->name . "-" . Auth::user()->nim . "." . $ktm->getClientOriginalExtension();
            $destination = storage_path('app/public/user/ktm');
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
