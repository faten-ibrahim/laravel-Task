<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsRequest;
use App\News;
use App\StaffMember;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\Traits\ImageUploadTrait;

class NewsController extends Controller
{
    use ImageUploadTrait;
    public function __construct()
    {
        $this->authorizeResource(News::class);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getNews();
        }
        return view('news.index');
    }

    public function getNews()
    {
        $news = News::with(['staffMember', 'staffMember.user' => function ($q) {
            $q->select('id', 'first_name');
        }]);
        return Datatables::of($news)
            ->addColumn('action', function ($row) {
                return view('news.actions', compact('row'));
            })
            ->editColumn('created_at', function ($news) {
                return $news->created_at ? with($news->created_at)->format('m/d/Y') : '';
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
    public function store(StoreNewsRequest $request)
    {
        $news = News::create($request->all());
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
    public function show(News $news)
    {
        $totalFiles = $news->files->pluck('name', 'mime_type');
        $imageExtentions = ['jpg', 'png'];
        $images = [];
        $files = [];
        foreach ($totalFiles as $key => $file) {
            if (!in_array($key, $imageExtentions)) {
                array_push($files, $file);
            } else {
                array_push($images, $file);
            }
        }
        return view('news.show', compact('news', 'images', 'files'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        $related=$news->relatedNews()->pluck('main_title','news.id');
        $staff = StaffMember::with(['user' => function ($q) {
            $q->select('id', 'first_name');
        }])->get();
        $staff = $staff->pluck("user.first_name", "id");
        return view('news.edit', compact('news', 'staff', 'related'));
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
        $news->update($request->all());
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

    public function getRelatedNews(Request $request)
    {
        $term = trim($request->q);
        if (empty($term)) {
            return \Response::json([]);
        }
        $resultNews = News::where('main_title', 'like', "%$term%")->published()->ofId($request->id)->get();
        $formatted_news = [];
        foreach ($resultNews as $news) {
            $formatted_news[] = ['id' => $news->id, 'text' => $news->main_title];
        }

        return \Response::json($formatted_news);
    }

    public function storeRelatedNews($userSelections, $news)
    {
        if ($userSelections) {
            if (count($userSelections) > 10) {
                $userSelections = array_slice($userSelections, 0, 10);
            }
            $news->relatedNews()->sync($userSelections);
        }
    }

    public function togglePublish(News $news)
    {
        $news->lockForUpdate()->first();
        $news->is_published = !$news->is_published;
        $news->save();
        DB::commit();
        return redirect()->route('news.index');
    }
}
