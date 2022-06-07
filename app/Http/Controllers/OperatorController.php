<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OperatorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        $users = User::where('role_id', '>', 1)->with('roles')->get();

        return view('backend.operator.index', ['users' => $users]);
    }

    public function create()
    {
        $roles = Role::all();

        return view('backend.operator.add', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        // Validations
        $request->validate([
            'name'          => 'required',
            'jk'          => 'required',
            'email'         => 'required|unique:users,email',
            'mobile_number' => 'required|numeric',
            'role_id'       =>  'required|exists:roles,id',
            'status'        =>  'required|numeric|in:0,1',
        ]);

        // Store Data
        $user = User::create([
            'id'            => substr(str_shuffle("0123456789"), 5, 9),
            'name'          => $request->name,
            'email'         => $request->email,
            'alamat'        => $request->alamat,
            'jk'            => $request->jk,
            'nim'           => time(),
            'mobile_number' => $request->mobile_number,
            'role_id'       => $request->role_id,
            'status'        => $request->status,
            'password'      => Hash::make($request->name)
        ]);

        // Assign Role To User
        $user->assignRole($user->role_id);
        if ($user) {
            return redirect()->route('operator.index')->with('success', 'User Berhasil ditambah!.');
        } else {
            return redirect()->route('operator.index')->with('error', 'User Gagal ditambah!.');
        }
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('backend.operator.detail', compact('user'));
    }

    public function edit(User $operator)
    {
        $roles = Role::all();
        return view('backend.operator.edit')->with([
            'roles'     => $roles,
            'operator'  => $operator
        ]);
    }

    public function update(Request $request, User $operator)
    {
        // Validations
        $request->validate([
            'name'          => 'required',
            'jk'            => 'required',
            'email'         => 'required|unique:users,email,' . $operator->id . ',id',
            'mobile_number' => 'required|numeric|digits:10',
            'role_id'       =>  'required|exists:roles,id',
        ]);

        // Store Data
        User::whereId($operator->id)->update([
            'name'          => $request->name,
            'email'         => $request->email,
            'alamat'        => $request->alamat,
            'jk'            => $request->jk,
            'mobile_number' => $request->mobile_number,
            'role_id'       => $request->role_id,
        ]);

        // Delete Any Existing Role
        DB::table('model_has_roles')->where('model_id', $operator->id)->delete();

        // Assign Role To User
        $operator->assignRole($request->role_id);

        if ($operator) {
            return redirect()->route('operator.index')->with('success', 'Master Berhasil dibaharui!.');
        } else {
            return redirect()->route('operator.index')->with('error', 'Master Gagal dibaharui!.');
        }
    }

    public function destroy(User $operator, Request $request)
    {
        // Delete User
        $delete = User::whereId($request->delete_id)->delete();
        if ($delete) {
            return redirect()->route('operator.index')->with('success', 'Pengurus Berhasil dihapus!.');
        } else {
            return redirect()->back()->with('error', 'Pengurus Gagal dihapus!.');
        }
    }

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

        // Update Status
        $user = User::whereId($user_id)->update(['status' => $status]);

        // Masssage
        if ($user) {
            if ($status == 0) {
                return redirect()->route('operator.index')->with('info', 'Status User Inactive!.');
            }
            return redirect()->route('operator.index')->with('info', 'Status User Active!.');
        } else {
            return redirect()->route('operator.index')->with('error', 'Gagal diperbarui');
        }
    }
}
