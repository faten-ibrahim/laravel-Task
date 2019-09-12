<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function create($name){
        $role = Role::create(['name' => $name]);
    }

    public function update($id,$name){
        $role=Role::find($id);
        $role = $role->update(['name' => $name]);
    }

    public function delete($id){
        $role=Role::find($id);
        $role = $role->delete();
    }
}
