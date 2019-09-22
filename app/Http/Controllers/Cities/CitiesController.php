<?php

namespace App\Http\Controllers\Cities;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\City;
use App\Country;
use App\Http\Requests\StoreCityRequest;
use DataTables;

class CitiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:city-list');
        $this->middleware('permission:city-create', ['only' => ['create','store']]);
        $this->middleware('permission:city-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:city-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            return $this->get_cities();
            
        }
        return view('cities.index');
    }

    public function get_cities()
    {
        $cities = City::with('country');
        $cities=$cities->take(10);
        return datatables()->of($cities)
            ->addIndexColumn()

            ->addColumn('action', function ($row) {
                $rowId=$row->id;
                return  view('cities.actions',compact('rowId'));
            })
            ->setTotalRecords($cities->count())
            ->rawColumns(['action'])
            ->make(true);
        
    }

    public function create()
    {
        $countries = Country::all();
        return view('cities.create',[
            'countries' => $countries,
        ]);
    }

    public function store(StoreCityRequest $request)
    {
        City::create($request->all());
        return redirect()->route('cities.index')->with('status', 'City Created successfully !');
    }

    public function edit(City $city)
    {
        $countries = Country::all();
        return view('cities.edit', [
            'city' => $city,
            'countries' => $countries,
        ]);
    }

    public function update(City $city, StoreCityRequest $request)
    {
        $city->update($request->all());
        return redirect()->route('cities.index')->with('status', 'City Updated successfully !');
    }

    public function delete(City $city)
    {
        $city->delete();
        return redirect()->route('cities.index')->with('status', 'City Deleted successfully !');
    }
}
