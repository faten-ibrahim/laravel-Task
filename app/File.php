<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * Get the owning imageable model.
     */
    public function fileable()
    {
        return $this->morphTo();
    }
}
