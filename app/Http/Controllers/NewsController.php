<?php

namespace App\Http\Controllers;

use App\File;
use App\Http\Requests\StoreNewsRequest;
use App\News;
use App\RelatedNews;
use App\StaffMember;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use App\Traits\ImageUploadTrait;

class NewsController extends Controller
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
        $news = $this->getRelatedNews();
        return view('news.create', compact('news'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewsRequest $request)
    {
        $con = trim($request->content, "<p>");
        $con = trim($con, "</p>");
        $news = News::create(array_merge($request->all(), ['content' => $con]));
        $this->storeFilesIntoDatabase($request, $news);
        $this->storeRelatedNews($request->get('related'), $news);
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
        $News = $this->getRelatedNews();
        $related = $news->relatedNews()->select("related_news_id")->get()->toArray();
        $related = array_column($related, 'related_news_id');
        $staff = StaffMember::with(['user' => function ($q) {
            $q->select('id', 'first_name');
        }])->get();
        $staff = $staff->pluck("user.first_name", "id");
        return view('news.edit', compact('news', 'News', 'staff', 'related'));
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
        // dd("hererree");
        $con = trim($request->content, "<p>");
        $con = trim($con, "</p>");
        $news->update(array_merge($request->all(), ['content' => $con]));
        $this->storeFilesIntoDatabase($request, $news);
        $this->storeRelatedNews($request->get('related'), $news);
        return redirect()->route('news.index')->with('status', 'News updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('news.index')->with('status', 'News deleted successfully !');
    }

    public function getRelatedNews()
    {
        $news = News::pluck("main_title", "id");
        return $news;
    }

    public function storeFiles(Request $request)
    {
        return $this->storeFilesIntoStorage($request);
    }

    public function storeRelatedNews($userSelections,$news)
    {
        if ($userSelections) {
            $news->relatedNews()->delete();
            if (count($userSelections) > 10) {
                $userSelections = array_slice($userSelections, 0, 10);
            }
            foreach ($userSelections as $relatedNewsId) {
                $news->relatedNews()->create([
                    'related_news_id' => $relatedNewsId,
                ]);
            }
        }
    }
}
