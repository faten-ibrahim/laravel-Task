<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Http\Requests\StoreStaffMemberRequest;
use App\Http\Requests\UpdateStaffMemberRequest;
use App\Job;
use App\StaffMember;
use App\User;
use Illuminate\Http\Request;
use DataTables;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Traits\ImageUploadTrait;
class StaffController extends Controller
{
    use SendsPasswordResetEmails,ImageUploadTrait;
    

    public function __construct()
    {
        $this->authorizeResource(StaffMember::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getStaffMembers();
        }
        return view('staff.index');
    }

    public function getStaffMembers()
    {
        $staffMembers = StaffMember::with(['user', 'job', 'role', 'user.city', 'user.city.country']);
        return Datatables::of($staffMembers)
            ->addColumn('action', function ($row) {
                return view('staff.actions', compact('row'));
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
        $roles = Role::select("name", "id")->get();
        $jobs = Job::select("name", "id")->get();
        $countries = Country::pluck("full_name", "id");
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
        $image_url = $this->get_image_url($request);
        $staff_user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'gender' => $request->gender,
            'city_id' => $request->city_id,
            'country_id' => $request->country_id,
            'password' => Hash::make('123456'),

        ]);
        if ($image_url) {
            // Save images
            $this->saveImages($request, $image_url, $staff_user->id);
        }

        StaffMember::create([
            'user_id' => $staff_user->id,
            'job_id' => $request->job_id,
            'role_id' => $request->role_id,
        ]);

        $this->sendResetLinkEmail($request);

        return redirect()->route('staff.index')->with('status', 'Staff Member Created successfully !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffMember $staff)
    {
        $roles = Role::select("name", "id")->get();
        $jobs = Job::select("name", "id")->get();
        $countries = Country::pluck("full_name", "id");
        $user = $staff->user;
        // dd($user);
        return view('staff.edit', compact('roles', 'jobs', 'countries', 'user', 'staff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStaffMemberRequest $request, StaffMember $staff)
    {
        $image_url = $this->get_image_url($request);
        $staff->update([
            'job_id' => $request->job_id,
            'role_id' => $request->role_id,
        ]);
        $user = $staff->user;
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'gender' => $request->gender,
            'city_id' => $request->city_id,
            'country_id' => $request->country_id,

        ]);
        if ($image_url) {
            // Save images
            $this->saveImages($request, $image_url, $user->id);
        }

        return redirect()->route('staff.index')->with('status', 'Staff Member Updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffMember $staff)
    {
        $staff->user->delete();
        return redirect()->route('staff.index')->with('status', 'Staff Member deleted successfully !');
    }

    public function ban(StaffMember $staff)
    {
        // dd('nnnnnn');
        $staff->user->ban();

        return redirect()->route('staff.index')->with('success', 'Staff Member de-activated Successfully..');
    }
    public function unban(StaffMember $staff)
    {
        dd('unnn');
        $staff->user->unban();
        $staff->user->banned_at=NULL;
        return redirect()->route('home')->with('success', 'Staff Member activated Successfully..');
    }
}
