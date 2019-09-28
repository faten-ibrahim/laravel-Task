<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Http\Requests\StoreStaffMemberRequest;
use App\Job;
use App\StaffMember;
use App\User;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Spatie\Permission\Models\Role;
use App\Upload;
use JD\Cloudder\Facades\Cloudder as Cloudder;
use Illuminate\Support\Facades\Hash;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class StaffController extends Controller
{
    use SendsPasswordResetEmails {
        sendResetLinkEmail as protected send_resetLink_email;
    }


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
            ->select('staff_members.id as id', 'roles.name as role_name', 'jobs.name as job_name', 'countries.full_name as country_name', 'cities.name as city_name', 'users.first_name', 'users.last_name', 'users.email', 'users.gender', 'users.phone');
        // dd($staff_members);
        return Datatables::of($staff_members)
            ->addColumn('action', function ($row) {
                // $rowId = $row->id;
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
        $roles = Role::all();
        $jobs = Job::all();
        $cities = City::all();
        $countries = Country::pluck("full_name", "id");
        return view('staff.create', compact('roles', 'jobs', 'cities', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image_url = $this->validate_image($request);
        $staff_user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'gender' => $request->gender,
            'city_id' => $request->city,
            'country_id' => $request->country_id,
            'password' => Hash::make('123456'),

        ]);
        if ($image_url) {
            // Save images
            $this->saveImages($request, $image_url, $staff_user->id);
        }
        DB::table('staff_members')->insert([
            'user_id' => $staff_user->id,
            'job_id' => $request->job_id,
            'role_id' => $request->role_id,
        ]);

        $this->send_resetLink_email($request);

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
        // dd($staff);
        $roles = Role::get();
        $jobs = Job::all();
        $cities = City::all();
        $countries = Country::all();
        $user = User::find($staff->user_id);
        return view('staff.edit', compact('roles', 'jobs', 'cities', 'countries', 'user', 'staff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaffMember $staff)
    {

        $image_url = $this->validate_image($request);
        $staff->update([
            'job_id' => $request->job_id,
            'role_id' => $request->role_id,
        ]);
        $user = User::find($staff->user_id);
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
        $staff->delete();
        return redirect()->route('staff.index')->with('status', 'Staff Member deleted successfully !');
    }

    public function uploadImages($image, $name, $image_name)
    {
        Cloudder::upload($image_name);
        list($width, $height) = getimagesize($image_name); // filesize($image_name);//$image_name->getSize();
        $image_url = Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
        //save to uploads directory
        $image->move(public_path("uploads"), $name);

        return $image_url;
    }

    public function saveImages(Request $request, $image_url, $user_id)
    {
        $image = new Upload();
        $image->user_id = $user_id;
        $image->image_name = $request->file('image_name')->getClientOriginalName();
        $image->image_url = $image_url;
        $image->save();
    }

    public function validate_image($request)
    {
        $this->validate($request, [
            'image_name' => 'image|mimes:jpeg,bmp,jpg,png|max:2048',
        ]);
        if ($request->hasFile('image_name') && $request->file('image_name')->isValid()) {
            $image = $request->file('image_name');
            $name = $request->file('image_name')->getClientOriginalName();
            $image_name = $request->file('image_name')->getRealPath();
            $image_url = $this->uploadImages($image, $name, $image_name);

            return $image_url;
        }

        return 0;
    }

    public function getCityList(Request $request)
    {
        $cities = City::where("country_id", $request->country_id)
            ->pluck("name", "id");
        return response()->json($cities);
    }
}
