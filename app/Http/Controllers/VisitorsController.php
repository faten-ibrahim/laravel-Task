<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Http\Requests\StoreVisitorRequest;
use App\Http\Requests\UpdateVisitorRequest;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Spatie\Permission\Models\Role;
use App\Upload;
use App\User;
use App\Visitor;
use JD\Cloudder\Facades\Cloudder as Cloudder;
use Illuminate\Support\Facades\Hash;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class VisitorsController extends Controller
{
    use SendsPasswordResetEmails;
    public function __construct()
    {
        $this->authorizeResource(Visitor::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->get_visitors();
        }
        return view('visitors.index');
    }

    public function get_visitors()
    {
        $visitors = Visitor::where('users.is_visitor', '=', 1)
            ->Join('cities', 'users.city_id', '=', 'cities.id')
            ->Join('countries', 'users.country_id', '=', 'countries.id')
            ->select('countries.full_name as country_name', 'cities.name as city_name', 'users.*');
        return Datatables::of($visitors)
            ->addColumn('action', function ($row) {
                // $rowId = $row->id;
                return view('visitors.actions', compact('row'));
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
        $countries = Country::pluck("full_name", "id");
        return view('visitors.create', compact('cities', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVisitorRequest $request)
    {
        $image_url = $this->validate_image($request);
        $visitor = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'gender' => $request->gender,
            'city_id' => $request->city_id,
            'country_id' => $request->country_id,
            'password' => Hash::make('123456'),

        ]);
        // $visitor->password=Hash::make('123456');
        $visitor->is_visitor = 1;
        $visitor->save();
        if ($image_url) {
            // Save images
            $this->saveImages($request, $image_url, $visitor->id);
        }

        $this->sendResetLinkEmail($request);

        return redirect()->route('visitors.index')->with('status', 'Visitor Created successfully !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Visitor $visitor)
    {
        $countries = Country::pluck("full_name", "id");
        // dd($visitor);
        return view('visitors.edit', compact('countries', 'visitor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVisitorRequest $request, Visitor $visitor)
    {
        dd('update');
        $image_url = $this->validate_image($request);
        $visitor->update($request->all());
        if ($image_url) {
            // Save images
            $this->saveImages($request, $image_url, $visitor->id);
        }

        return redirect()->route('visitors.index')->with('status', 'Visitor Updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visitor $visitor)
    {
        $visitor->delete();
        return redirect()->route('visitors.index')->with('status', 'Visitor deleted successfully !');
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
        // $this->validate($request, [
        //     'image_name' => 'image|mimes:jpeg,bmp,jpg,png|max:2048',
        // ]);
        if ($request->hasFile('image_name') && $request->file('image_name')->isValid()) {
            $image = $request->file('image_name');
            $name = $request->file('image_name')->getClientOriginalName();
            $image_name = $request->file('image_name')->getRealPath();
            $image_url = $this->uploadImages($image, $name, $image_name);

            return $image_url;
        }

        return 0;
    }

    public function ban(Visitor $visitor)
    {
        $this->authorize('active', $visitor);
        $visitor->bans()->create();
        $visitor->is_active = 0;
        $visitor->save();
        return redirect()->route('visitors.index')->with('success', 'Visitor de-activated Successfully..');
    }
    public function unban(Visitor $visitor)
    {
        $this->authorize('active', $visitor);
        $visitor->unban();
        $visitor->is_active = 1;
        $visitor->save();
        return redirect()->route('visitors.index')->with('success', 'Visitor activated Successfully..');
    }
    public function getCityList(Request $request)
    {
        $cities = City::where("country_id", $request->country_id)
            ->pluck("name", "id");
        return response()->json($cities);
    }
}
