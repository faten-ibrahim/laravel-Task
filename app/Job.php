<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Job extends Model
{
    use SoftDeletes;
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


    public function staff()
    {
        return $this->hasMany(StaffMember::class);
    }
}
