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

    public function index(Request $request)
    {
        $this->authorize('viewAny', City::class);
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
                return  view('cities.actions',compact('row'));
            })
            ->setTotalRecords($cities->count())
            ->rawColumns(['action'])
            ->make(true);
        
    }

    public function create()
    {
        $this->authorize('create', City::class);
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
        $this->authorize('update', $city);
        $countries = Country::all();
        return view('cities.edit', [
            'city' => $city,
            'countries' => $countries,
        ]);
    }

    public function update(City $city, StoreCityRequest $request)
    {
        $this->authorize('update', $city);
        $city->update($request->all());
        return redirect()->route('cities.index')->with('status', 'City Updated successfully !');
    }
   
    public function destroy(City $city)
    {
        $this->authorize('delete', $city);
        $city->delete();
        return redirect()->route('cities.index')->with('status', 'City Deleted successfully !');
    }
}

