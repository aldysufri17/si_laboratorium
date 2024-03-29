<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
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
     * List User 
     * @param Nill
     * @return Array $user
     * @author Shani Singh
     */
    public function index()
    {
        $users = User::where('role', 1)->get();

        return view('backend.users.index', ['users' => $users]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::FindorFail(decrypt($id));
        return view('backend.users.detail', compact('user'));
    }

    /**
     * Create User 
     * @param Nill
     * @return Array $user
     * @author Shani Singh
     */
    public function create()
    {
        $roles = Role::all();

        return view('backend.users.add', ['roles' => $roles]);
    }

    /**
     * Store User
     * @param Request $request
     * @return View Users
     * @author Shani Singh
     */
    public function store(Request $request)
    {
        // Validations
        $request->validate([
            'name'          => 'required',
            'alamat'        => 'required',
            'email'         => 'required|unique:users,email',
            'jk'            => 'required',
            'mobile_number' => 'required|numeric',
            'nim'           => 'required|numeric',
            'status'        =>  'required|numeric|in:0,1',
        ]);

        if ($request->foto) {
            $foto = $request->foto;
            $new_foto = date('Y-m-d') . "-" . $request->name . "-" . $request->nim . "." . $foto->getClientOriginalExtension();
            $destination = 'images/user/';
            $foto->move($destination, $new_foto);
            $user = User::create([
                'id'            => substr(str_shuffle("0123456789"), 0, 8),
                'name'          => $request->name,
                'email'         => $request->email,
                'nim'           => $request->nim,
                'alamat'        => $request->alamat,
                'mobile_number' => $request->mobile_number,
                'post'          => 0,
                'role'          => 1,
                'jk'            => $request->jk,
                'status'        => $request->status,
                'foto'          => $new_foto,
                'password'      => bcrypt(12345678),

            ]);
        } else {
            $user = User::create([
                'id'            => substr(str_shuffle("0123456789"), 0, 8),
                'name'          => $request->name,
                'email'         => $request->email,
                'nim'           => $request->nim,
                'alamat'        => $request->alamat,
                'mobile_number' => $request->mobile_number,
                'post'          => 0,
                'role'          => 1,
                'jk'            => $request->jk,
                'status'        => $request->status,
                'password'      => bcrypt(12345678),
            ]);
        }
        // Assign Role To User
        $user->assignRole($user->role);
        if ($user) {
            return redirect()->route('users.index')->with('success', 'User Berhasil ditambah!.');
        }
        return redirect()->route('users.index')->with('error', 'User Gagal ditambah!.');
    }

    /**
     * Update Status Of User
     * @param Integer $status
     * @return List Page With Success
     * @author Shani Singh
     */
    public function updateStatus($user_id, $status)
    {
        // Validation
        Validator::make([
            'user_id'   => $user_id,
            'status'    => $status
        ], [
            'user_id'   =>  'required|exists:users,id',
            'status'    =>  'required|in:0,1',
        ]);
        $user_id = decrypt($user_id);
        // Update Status
        $user = User::whereId($user_id)->update(['status' => $status]);

        // Masssage
        if ($user) {
            if ($status == 0) {
                return redirect()->route('users.index')->with('info', 'Status User Inactive!.');
            }
            return redirect()->route('users.index')->with('info', 'Status User Active!.');
        } else {
            return redirect()->route('users.index')->with('error', 'Gagal diperbarui');
        }
    }

    /**
     * Edit User
     * @param Integer $user
     * @return Collection $user
     * @author Shani Singh
     */
    public function edit($user)
    {
        $user = User::whereId(decrypt($user))->first();
        $roles = Role::all();
        return view('backend.users.edit')->with([
            'roles' => $roles,
            'user'  => $user
        ]);
    }

    /**
     * Update User
     * @param Request $request, User $user
     * @return View Users
     * @author Shani Singh
     */
    public function update(Request $request, User $user)
    {
        // Validations
        $request->validate([
            'name'          => 'required',
            'alamat'        => 'required',
            'jk'            => 'required',
            'email'         => 'required|unique:users,email,' . $user->id . ',id',
            'mobile_number' => 'required|numeric',
        ]);
        if ($request->foto) {
            $bb = User::whereid($user->id)->first();
            if (file_exists(public_path('/images/user/' . $bb->foto))) {
                unlink('images/barang/' . $bb->foto);
            }
            $foto = $request->foto;
            $new_foto = date('Y-m-d') . "-" . $request->name . "-" . $request->nim . "." . $foto->getClientOriginalExtension();
            $destination = 'images/user/';
            $foto->move($destination, $new_foto);
            // Store Data
            $user_updated = User::whereId($user->id)->update([
                'name'          => $request->name,
                'alamat'        => $request->alamat,
                'jk'            => $request->jk,
                'nim'           => $request->nim,
                'email'         => $request->email,
                'foto'          => $new_foto,
                'mobile_number' => $request->mobile_number,
            ]);
        } else {
            $user_updated = User::whereId($user->id)->update([
                'name'          => $request->name,
                'alamat'        => $request->alamat,
                'jk'            => $request->jk,
                'nim'           => $request->nim,
                'email'         => $request->email,
                'mobile_number' => $request->mobile_number,
            ]);
        }
        if ($user_updated) {
            return redirect()->route('users.index')->with('success', 'User Berhasil diperbarui!.');
        } else {
            return redirect()->back()->withInput()->with('error', 'User Gagal diperbarui!.');
        }
    }

    /**
     * Delete User
     * @param User $user
     * @return Index Users
     * @author Shani Singh
     */
    public function delete(User $user, Request $request)
    {
        $userfoto = User::whereId($request->delete_id)->first();
        if ($userfoto->foto) {
            unlink('images/user/' . $userfoto->foto);
        }
        // Delete User
        $delete = User::whereId($request->delete_id)->delete();
        if ($delete) {
            return redirect()->route('users.index')->with('success', 'Pengguna Berhasil dihapus!.');
        } else {
            return redirect()->back()->with('error', 'Pengguna Gagal dihapus!.');
        }
    }

    public function reset($user, Request $request)
    {
        $user = User::whereId($user)->update(['password' => bcrypt('secret')]);
        return redirect()->back()->with('success', 'Password Berhasil direset!.');
    }

    public function import()
    {
        $this->validate(request(), [
            'file' => 'mimes:csv,xls,xlsx'
        ]);

        if (request()->file('file') == null) {
            return redirect()->back()->with('info', 'Masukkan file terlebih dahulu!.');
        }
        $fileName = date('Y-m-d') . '_' . 'Import Barang' . '_' . 'Pengguna';
        request()->file('file')->storeAs('reports', $fileName, 'public');
        Excel::import(new UsersImport, request()->file('file'));
        return redirect()->back()->with('success', 'Pengguna berhasil ditambah!.');
    }

    public function export()
    {
        $fileName = date('Y-m-d') . '_' . 'Data Pengguna' . '.xlsx';
        return Excel::download(new UsersExport,  $fileName);
    }

    public function userPdf()
    {
        $user = User::where('status', 1)->get();
        $pdf = Pdf::loadview('backend.users.pdf_user', compact('user'));

        return $pdf->download("Data Pengguna" . "_" . date('d-m-Y') . '.pdf');
    }
}
