<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        $roles = Role::paginate(10);

        return view('backend.roles.index', [
            'roles' => $roles
        ]);
    }

    public function create()
    {
        return view('backend.roles.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Role::create($request->all());
        return redirect()->route('roles.index')->with('success', 'Role berhasil dibuat.');
    }

    public function edit($id)
    {
        $role = Role::whereId($id)->first();
        return view('backend.roles.edit', ['role' => $role]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Role::whereId($id)->update([
            'name' => $request->name
        ]);
        return redirect()->route('roles.index')->with('success', 'Role berhasil diedit.');
    }

    public function destroy($id, Request $request)
    {
        Role::whereId($request->delete_id)->delete();
        return redirect()->route('roles.index')->with('success', 'Roles berhasil dihapus.');
    }
}
