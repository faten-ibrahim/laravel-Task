<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description'
    ];

    private $reserved=['reporter','writter'];

    public function is_reserved(){
        if (in_array($this->attributes['name'], $this->reserved, TRUE)){
            return true;
        }
        return false;
    }
}
