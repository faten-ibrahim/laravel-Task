<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffMember extends Model
{
    protected $table = "staff_members";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','job_id', 'role_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
