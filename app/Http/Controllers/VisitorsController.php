<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Http\Requests\StoreVisitorRequest;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use DataTables;
use App\Visitor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VisitorsExport;
use DB;

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
            return $this->getVisitors();
        }
        return view('visitors.index');
    }

    public function getVisitors()
    {
        $visitors = Visitor::with(['city', 'city.country'])->where('type', 'visitor')
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
        $visitor = Visitor::create(array_merge($request->all(), ['password' => Hash::make('123456')]));
        $this->storeImage($request, $visitor);
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
        $cities = City::pluck("name", "id");
        $image_name = $visitor->file ? $visitor->file()->pluck("name")[0] : "";
        return view('visitors.edit', compact('countries', 'cities', 'visitor', 'image_name'));
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
        $visitor->update($request->all());
        $this->updateImage($request, $visitor);
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
        $visitor->lockForUpdate()->first();
        $visitor->is_active = !$visitor->is_active;
        $visitor->save();
        DB::commit();
        return redirect()->route('visitors.index');
    }

    public function export()
    {
        return Excel::download(new VisitorsExport, 'visitors.xlsx');
    }

    public function getVisitorsList(Request $request)
    {
        $term = trim($request->q);
        if (empty($term)) {
            return \Response::json([]);
        }
        $resultVisitors = Visitor::where('first_name', 'like', "%$term%")->orWhere('last_name', 'like', "%$term%")->select('id','first_name','last_name')->get();
        $formattedVisitors = [];
        foreach ($resultVisitors as $visitor) {
            $formattedVisitors[] = ['id' => $visitor->id, 'text' => $visitor->first_name." ".$visitor->last_name];
        }

        return \Response::json($formattedVisitors);
    }
}
