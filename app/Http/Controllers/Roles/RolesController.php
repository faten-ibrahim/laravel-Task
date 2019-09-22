<?php

namespace App\Http\Controllers\Roles;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use Spatie\Permission\Models\Role;
use DataTables;
use Spatie\Permission\Models\Permission;
use DB;


class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:role-list');
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
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
        // $count_total=Role::count();
        $roles = Role::query();
        $roles = $roles->take(10);
        return Datatables::of($roles)
                ->addColumn('action', function ($row) {
                    $rowId = $row->id;
                    return view('roles.actions', compact('rowId'));
                    })
                    // ->with([
                    //         "recordsTotal"    => $count_total,
                    // ])
                ->setTotalRecords($roles->count())
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


    public function delete(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('status', 'Role Deleted successfully !');
    }
}
