<?php

namespace App\Http\Controllers\Roles;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use DataTables;
use App\Http\Requests\StoreRoleRequest;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('roles.index');
    }

    public function get_roles()
    {
        $roles = Role::all();
        // dd(datatables()->of($roles)->make(true));
        return datatables()->of($roles)->make(true);
    }

    public function create()
    {

        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|max:150|min:3',
            'description' => 'required|max:250|min:10',
        ]);
        Role::create($request->all());
        return redirect()->route('roles.index')->with('status', 'Role Created successfully !');
    }

    public function edit(Role $role)
    {
        return view('roles.edit', [
            'role' => $role,
        ]);
    }

    public function update(Role $role, Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|max:150|min:3',
            'description' => 'required|max:250|min:10',
        ]);
        $role->update($request->all());
        return redirect()->route('roles.index')->with('status', 'Role Updated successfully !');
    }

    public function delete(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('status', 'Role Deleted successfully !');
    }
}
