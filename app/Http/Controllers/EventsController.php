<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventVisitor;
use App\Http\Requests\StoreEventRequest;
use Illuminate\Http\Request;
use DataTables;
use App\Traits\ImageUploadTrait;
use Carbon\Carbon;

class EventsController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getEvents();
        }
        return view('events.index');
    }

    public function getEvents()
    {
        $events = Event::select('id', 'main_title', 'secondary_title', 'start_date', 'end_date', 'location', 'is_published');
        return Datatables::of($events)
            ->addColumn('action', function ($row) {
                return view('events.actions', compact('row'));
            })
            ->editColumn('start_date', function ($events) {
                return $events->start_date ? with($events->start_date)->format('m/d/Y') : '';
            })
            ->editColumn('end_date', function ($events) {
                return $events->end_date ? with($events->end_date)->format('m/d/Y') : '';
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
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        $event = Event::create($request->all());
        $this->storeFilesIntoDatabase($request, $event);
        $event->visitors()->attach($request->get('visitors'));
        return redirect()->route('events.index')->with('status', 'Events added successfully !');
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
    public function edit(Event $event)
    {
        $visitors = $event->visitors()->select('first_name', 'last_name', 'visitor_id')->get();
        return view('events.edit', compact('event','visitors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEventRequest $request, Event $event)
    {
        // dd($request->all());
        $event->update($request->all());
        $this->storeFilesIntoDatabase($request, $event);
        $event->visitors()->sync($request->get('visitors'));
        return redirect()->route('events.index')->with('status', 'Events updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('status', 'Events deleted successfully !');
    }
}
