<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class File extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','mime_type','type'];
    /**
     * Get the owning imageable model.
     */
    public function fileable()
    {
        return $this->morphTo();
    }

    public function description()
    {
        return $this->hasOne(FileDescription::class);
    }
}
