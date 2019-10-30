<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Folder extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','description'];

     /**
     * Get the folder's media.
     */
    public function files()
    {
        return $this->morphMany('App\File', 'fileable');
    }

    public function staff()
    {
        return $this->belongsToMany(StaffMember::class,'folder_staff','folder_id','staff_id');
    }

    // public function scopeId($query)
    // {
    //     return $query->get('id');
    // }

}
