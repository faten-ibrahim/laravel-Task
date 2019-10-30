<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FolderStaff extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'folder_id','staff_id'
    ];
}
