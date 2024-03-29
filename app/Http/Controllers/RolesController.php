<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use Spatie\Permission\Models\Role;
use DataTables;
use Spatie\Permission\Models\Permission;
use DB;
use Spatie\Permission\Contracts\Role as SpatieRole;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->get_roles();
        }
        return view('roles.index');
    }

    public function get_roles()
    {
        $roles = Role::query();
        return Datatables::of($roles)
            ->addColumn('action', function ($row) {
                $rowId = $row->id;
                return view('roles.actions', compact('rowId'));
            })
            ->rawColumns(['action'])
            ->make(TRUE);
    }

    public function create()
    {
        $permission = Permission::get();
        return view('roles.create', compact('permission'));
    }

    public function store(StoreRoleRequest $request)
    {
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
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    public function update(Role $role, StoreRoleRequest $request)
    {
        $role->update([
            'name' => $request->name,
            'description' => $request->description
        ]);
        $role->syncPermissions($request->permission);

        return redirect()->route('roles.index')->with('status', 'Role Updated successfully !');
    }


    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('status', 'Role Deleted successfully !');
    }
}
