<?php

namespace App\Http\Controllers\Roles;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use DataTables;
use Spatie\Permission\Models\Permission;
use DB;

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
        $permission = Permission::get();
        return view('roles.create', compact('permission'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|max:150|min:3',
            'description' => 'required|max:250|min:10',
            'permission' => 'required',
        ]);
        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description
        ]);
        $role->syncPermissions($request->permission);
        return redirect()->route('roles.index')->with('status', 'Role Created successfully !');
    }

    public function edit(Role $role)
    {
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role->id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();
        return view('roles.edit',compact('role','permission','rolePermissions'));
    }

    public function update(Role $role, Request $request)
    {
        $request->validate([
            'name' => 'required|max:150|min:3',
            'description' => 'required|max:250|min:10',
            'permission' => 'required',
        ]);
        $role->update([
            'name' => $request->name,
            'description' => $request->description
        ]);
        $role->syncPermissions($request->permission);

        return redirect()->route('roles.index')->with('status', 'Role Updated successfully !');
    }

    public function delete(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('status', 'Role Deleted successfully !');
    }
}
