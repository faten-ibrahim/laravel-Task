<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Job::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->get_jobs();
        }
        return view('jobs.index');
    }

    public function get_jobs()
    {
        $jobs = Job::query();
        return datatables()->of($jobs)
            ->addIndexColumn()

            ->addColumn('action', function ($row) {
                return  view('jobs.actions', compact('row'));
            })
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
        Job::create($request->all());
        return redirect()->route('jobs.index')->with('status', 'Job Created successfully !');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        return view('jobs.edit', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        if ($job->is_reserved()) {
            return redirect()->route('jobs.index')->with('status', 'Job can not be Updated !');
        }
        $job->update($request->all());

    return redirect()->route('jobs.index')->with('status', 'Job Updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        if ($job->is_reserved()) {
            return redirect()->route('jobs.index')->with('status', 'Job can not be Deleted !');
        }
        $job->delete();
        return redirect()->route('jobs.index')->with('status', 'Job Deleted successfully !');
    }
}
