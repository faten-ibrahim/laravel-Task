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
        // $news = $this->getRelatedNews();
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
        // $News = $this->getRelatedNews($news->id);
        $related = $news->relatedNews()->select("related_news_id")->get()->toArray();
        $related = array_column($related, 'related_news_id');
        $staff = StaffMember::with(['user' => function ($q) {
            $q->select('id', 'first_name');
        }])->get();
        $staff = $staff->pluck("user.first_name", "id");
        $files = $news->files()->pluck("name", "mime_type");
        // dd($files);
        return view('news.edit', compact('news', 'News', 'staff', 'related', 'files'));
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
        $this->updateFilesInDatabase($request, $news);
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
        $resultNews = News::where('main_title', 'like', "%$term%")->published()->get();
        $formatted_news = [];
        foreach ($resultNews as $news) {
            $formatted_news[] = ['id' => $news->id, 'text' => $news->main_title];
        }

        return \Response::json($formatted_news);

    }

    public function storeFiles(Request $request)
    {
        return $this->storeFilesIntoStorage($request);
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
