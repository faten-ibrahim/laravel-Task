<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileDescription extends Model
{
    use SoftDeletes;
    protected $table = "file_description";
    protected $fillable = [
        'file_id','file_name','description'
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
