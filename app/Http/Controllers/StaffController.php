<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Http\Requests\StoreStaffMemberRequest;
use App\Job;
use App\StaffMember;
use App\User;
use Illuminate\Http\Request;
use DataTables;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Traits\ImageUploadTrait;
use App\Upload;
use DB;

class StaffController extends Controller
{
    use SendsPasswordResetEmails, ImageUploadTrait;


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
        
        $staff_user = User::create(array_merge($request->all(),['password' => Hash::make('123456')]));
        $imageUrl = $this->getImageUrl($request);
        if ($imageUrl) {
            // Save images
            $this->saveImages($request, $imageUrl, $staff_user->id);
        }
       
        StaffMember::create(array_merge($request->all(),['user_id' => $staff_user->id]));
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
        $cities=City::pluck("name","id");
        $user = $staff->user;
        $image_name = Upload::where('user_id', '=', $user->id)->select('image_name')->first();
        // dd($image_name);
        // dd($user);
        return view('staff.edit', compact('roles', 'jobs', 'countries','cities', 'user', 'staff', 'image_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreStaffMemberRequest $request, StaffMember $staff)
    {
        $staff->update($request->all());
        $user = $staff->user;
        $user->update($request->all());
        $imageUrl = $this->getImageUrl($request);
        if ($imageUrl) {
            // Save images
            $this->saveImages($request, $imageUrl, $user->id);
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

    public function toggleBan(StaffMember $staff)
    {
        DB::beginTransaction();
        try {
            // DB::table('users')->lockForUpdate()->first();
            $staff->user->lockForUpdate()->first();
            $staff->user->is_active= !$staff->user->is_active;
            $staff->user->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
          } 
        return redirect()->route('staff.index');
    }

    public function returnStaff(Request $request)
    {
        if ($request->type == 'news') {
            $staff = User::whereHas('staff_member', function ($q) {
                $job_id = Job::where('name', 'reporter')->pluck('id')->first();
                $q->where('job_id', '=', $job_id);
            })->pluck("first_name", "id");

            // dd($staff);
        } else {
            $staff = User::whereHas('staff_member', function ($q) {
                $job_id = Job::where('name', 'writter')->pluck('id')->first();
                $q->where('job_id', '=', $job_id);
            })->pluck("first_name", "id");
            // dd("staff");
        }

        return response()->json($staff);
    }
}
