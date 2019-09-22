<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:job-list');
        $this->middleware('permission:job-create', ['only' => ['create','store']]);
        $this->middleware('permission:job-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:job-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return $this->get_jobs();
            
        }
        return view('jobs.index');
    }

    public function get_jobs()
    {
        $jobs = Job::query();
        $jobs=$jobs->take(10);
        return datatables()->of($jobs)
            ->addIndexColumn()

            ->addColumn('action', function ($row) {
                $rowId=$row->id;
                $jobName=$row->name;
                return  view('jobs.actions',compact(['rowId','jobName']));
            })
            ->setTotalRecords($jobs->count())
            ->rawColumns(['action'])
            ->make(true);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Job::create([
            'name' => $request->name,
            'description' => $request->description
        ]);
        return redirect()->route('jobs.index')->with('status', 'Job Created successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job=Job::find($id);
        return view('jobs.edit',compact('job'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $job=Job::find($id);
        if($job->name=='reporter')
        {
            return redirect()->route('jobs.index')->with('status', 'Job can not be Updated !');
        }
        $job->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('jobs.index')->with('status', 'Job Updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job=Job::find($id);
        if($job->name=='reporter')
        {
            return redirect()->route('jobs.index')->with('status', 'Job can not be Deleted !');
        }
        $job->delete();
        return redirect()->route('jobs.index')->with('status', 'Job Deleted successfully !');
    }
}
