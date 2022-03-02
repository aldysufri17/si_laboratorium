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


    /**
     * List User 
     * @param Nill
     * @return Array $user
     * @author Shani Singh
     */
    public function index()
    {
        $users = User::where('role_id', 1)->orwhere('role_id', 2)->with('roles')->paginate(5);

        return view('backend.operator.index', ['users' => $users]);
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

        return view('backend.operator.add', ['roles' => $roles]);
    }

    /**
     * Store User
     * \
     * @param Request $request
     * @return View Users
     * @author Shani Singh
     */
    public function store(Request $request)
    {
        // Validations
        $request->validate([
            'name'          => 'required',
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('backend.operator.detail', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $operator)
    {
        $roles = Role::all();
        return view('backend.operator.edit')->with([
            'roles'     => $roles,
            'operator'  => $operator
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $operator)
    {
        // Validations
        $request->validate([
            'name'    => 'required',
            'email'         => 'required|unique:users,email,' . $operator->id . ',id',
            'mobile_number' => 'required|numeric|digits:10',
            'role_id'       =>  'required|exists:roles,id',
        ]);

        // Store Data
        User::whereId($operator->id)->update([
            'name'          => $request->name,
            'email'         => $request->email,
            'alamat'        => $request->alamat,
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $operator)
    {
        // Delete User
        $user = User::whereId($operator->id)->delete();
        if ($user) {
            return redirect()->route('operator.index')->with('success', 'Master Berhasil dihapus!.');
        } else {
            return redirect()->back()->with('error', 'Master Gagal dihapus!.');
        }
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
