<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Http\Requests\StoreStaffMemberRequest;
use App\Job;
use App\User;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            return $this->get_staff_members();
        }
        return view('staff.index');
    }

    public function get_staff_members()
    {

        $staff_members = User::Join('cities', 'users.city_id', '=', 'cities.id')
            ->Join('countries', 'users.country_id', '=', 'countries.id')
            ->join('staff_members', 'staff_members.user_id', '=', 'users.id')
            ->Join('roles', 'staff_members.role_id', '=', 'roles.id')
            ->Join('jobs', 'staff_members.job_id', '=', 'jobs.id')
            ->select('staff_members.user_id', 'roles.name as role_name', 'jobs.name as job_name', 'countries.full_name as country_name', 'cities.name as city_name', 'users.*');

        return Datatables::of($staff_members)
            ->addColumn('action', function ($row) {
                $rowId = $row->id;
                return view('staff.actions', compact('rowId'));
            })
            ->rawColumns(['action'])
            ->make(TRUE);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $jobs = Job::all();
        $cities = City::all();
        $countries = Country::all();
        return view('staff.create', compact('roles', 'jobs', 'cities', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStaffMemberRequest $request)
    {
        dd("yytttttttttttttt");
        $user = User::create([
            'name' => $request->name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'gender' => $request->gender,
            'city_id' => $request->city_id,
            'country_id' => $request->country_id,
            'password' => '123456',

        ]);

        DB::table('staff_members')->create([
            'user_id' => $user->id,
            'job_id' => $request->job_id,
            'role_id' => $request->role_id,
        ]);
        return redirect()->route('staff.index')->with('status', 'User Created successfully !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::get();
        $jobs = Job::all();
        $cities = City::all();
        $countries = Country::all();
        return view('staff.edit', compact('roles', 'jobs', 'cities', 'countries','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreStaffMemberRequest $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'gender' => $request->gender,
            'city_id' => $request->city_id,
            'country_id' => $request->country_id,

        ]);

        DB::table('staff_members')->update([
            'job_id' => $request->job_id,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('staff.index')->with('status', 'User Updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('staff.index')->with('status', 'Staff Member deleted successfully !');
    }
}
