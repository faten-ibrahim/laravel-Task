<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelatedNews extends Model
{
    protected $table = "related_news";

    protected $fillable = [
        'news_id', 'related_news_id',
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
