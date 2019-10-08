<?php

namespace App\Http\Controllers;

use App\File;
use App\Http\Requests\StoreNewsRequest;
use App\News;
use App\StaffMember;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getNews();
        }
        return view('news.index');
    }

    public function getNews()
    {
        // $news = StaffMember::with(['news','user'=> function ($q) {
        //     $q->select('id','first_name');
        // }])->select('id','user_id');

        $news = News::with(['staffMember' => function ($q) {
            $q->select('id', 'user_id');
        }, 'staffMember.user' => function ($q) {
            $q->select('id', 'first_name');
        }]);
        return Datatables::of($news)
            ->addColumn('action', function ($row) {
                return view('news.actions', compact('row'));
            })
            ->editColumn('created_at', function ($news) {
                return $news->created_at ? with(new Carbon($news->created_at))->format('m/d/Y') : '';
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(created_at,'%m/%d/%Y') like ?", ["%$keyword%"]);
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
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $con = trim($request->content, "<p>");
        $con = trim($con, "</p>");
        $news = News::create(array_merge($request->all(), ['content' => $con]));

        if ($request->hasfile('files')) {
            foreach ($request->file('files') as $file) {
                $name = $file->getClientOriginalName();
                $file->move(public_path('/uploads/news/'), $name);
                $news->files()->create([
                    'name' => $name,
                    'mime_type' => $file->getClientOriginalExtension(),
                ]);
            }   
        }

        return redirect()->route('news.index')->with('status', 'News added successfully !');
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
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreNewsRequest $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        //
    }
}
