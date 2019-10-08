<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Http\Requests\StoreVisitorRequest;
use App\Http\Requests\UpdateVisitorRequest;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use DataTables;
use App\User;
use App\Visitor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VisitorsExport;

class VisitorsController extends Controller
{
    use SendsPasswordResetEmails, ImageUploadTrait;
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
        $visitors = Visitor::with(['city', 'city.country'])->where('is_visitor', '=', 1)
            ->select('id', 'first_name', 'last_name', 'phone', 'email', 'gender', 'city_id', 'is_active');
        return Datatables::of($visitors)
            ->addColumn('action', function ($row) {
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
        $image_url = $this->get_image_url($request);
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
        $cities=City::pluck("name","id");
        // dd($visitor);
        return view('visitors.edit', compact('countries','cities','visitor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreVisitorRequest $request, Visitor $visitor)
    {
        // dd($request->all());
        $image_url = $this->get_image_url($request);
        User::find($visitor->id)->update($request->all());
        // $visitor->update($request->all());
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

    public function toggleBan(Visitor $visitor)
    {
        if ($visitor->is_active) {
            $visitor->is_active = 0;
        } else {
            $visitor->is_active = 1;
        }
        $visitor->save();
        return redirect()->route('visitors.index');
    }

    public function export()
    {
        return Excel::download(new VisitorsExport, 'visitors.xlsx');
    }
}
