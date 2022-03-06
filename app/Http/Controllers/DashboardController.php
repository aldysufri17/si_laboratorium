<?php

namespace App\Http\Controllers;

use App\Models\Barang;
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
    public function index()
    {
        $user = User::where('role_id', 3)->count();
        $barang = Barang::all()->count();
        return view('backend.dashboard', compact(['user', 'barang']));
    }

    /**
     * User Profile
     * @param Nill
     * @return View Profile
     * @author Shani Singh
     */
    public function getProfile()
    {
        if (Auth::user()->role_id == 3) {
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
            'mobile_number' => 'required|numeric|digits:10',
        ]);

        #Update Profile Data
        $user = User::whereId(auth()->user()->id)->update([
            'name' => $request->name,
            'mobile_number' => $request->mobile_number,
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
}
