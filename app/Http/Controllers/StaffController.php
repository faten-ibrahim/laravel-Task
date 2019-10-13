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
        $staff_user = User::create(array_merge($request->all(), ['password' => Hash::make('123456')]));
        $staff = StaffMember::create(array_merge($request->all(), ['user_id' => $staff_user->id]));
        $this->storeImageIntoDatabase($request, $staff, "staff");
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
        $cities = City::pluck("name", "id");
        $user = $staff->user;
        $image_name = $staff->file ? $staff->file()->pluck("name")[0] : "";
        return view('staff.edit', compact('roles', 'jobs', 'countries', 'cities', 'user', 'staff', 'image_name'));
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
        $this->storeImageIntoDatabase($request, $staff, "staff");

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
            $staff->user->is_active = !$staff->user->is_active;
            $staff->user->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return redirect()->route('staff.index');
    }

    public function storeFiles(Request $request)
    {
        return $this->storeFileIntoStorage($request, "staff");
    }

    public function returnStaff(Request $request)
    {
        if ($request->type == 'news') {
            // $staff = User::whereHas('staff_member', function ($q) {
            //     $job_id = Job::where('name', 'reporter')->pluck('id')->first();
            //     $q->where('job_id', '=', $job_id);
            // })->pluck("first_name", "id");
            $job_id = Job::where('name', 'reporter')->pluck('id')->first();
            $staff = StaffMember::with(['user' => function ($q) {
                $q->select('id', 'first_name');
            }])->where('job_id', '=', $job_id)->get();
            $staff = $staff->pluck("user.first_name", "id");
        } else {
            $job_id = Job::where('name', 'writter')->pluck('id')->first();
            $staff = StaffMember::with(['user' => function ($q) {
                $q->select('id', 'first_name');
            }])->where('job_id', '=', $job_id)->get();
            $staff = $staff->pluck("user.first_name", "id");
        }

        return response()->json($staff);
    }
}
