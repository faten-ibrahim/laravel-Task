<?php

namespace App\Http\Controllers;

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
        $this->authorizeResource(City::class);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->get_cities();
        }
        return view('cities.index');
    }

    public function get_cities()
    {
        $cities = City::with('country');
        return datatables()->of($cities)
            ->addIndexColumn()

            ->addColumn('action', function ($row) {
                return  view('cities.actions', compact('row'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $countries = Country::all();
        return view('cities.create', compact('countries'));
    }

    public function store(StoreCityRequest $request)
    {
        City::create($request->all());
        return redirect()->route('cities.index')->with('status', 'City Created successfully !');
    }

    public function edit(City $city)
    {
        $countries = Country::all();
        return view('cities.edit', compact('city', 'countries'));
    }

    public function update(City $city, StoreCityRequest $request)
    {
        $city->update($request->all());
        return redirect()->route('cities.index')->with('status', 'City Updated successfully !');
    }

    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('cities.index')->with('status', 'City Deleted successfully !');
    }

    public function getCityList(Request $request)
    {
        $cities = City::where("country_id", $request->country_id)
            ->pluck("name", "id");
        return response()->json($cities);
    }
}
