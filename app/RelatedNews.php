<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class RelatedNews extends Model
{
    use SoftDeletes;
    protected $table = "news";

    protected $fillable = [
        'news_id', 'related_news_id',
    ];

    public function news()
    {
        return $this->belongsToMany(News::class,'related_news', 'related_news_id', 'news_id');
    }
}
