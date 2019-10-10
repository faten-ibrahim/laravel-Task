<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

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
        return $this->belongsTo(User::class)->select(array('id', 'first_name','last_name','email','gender','phone','city_id','is_active'));
    }

    public function role()
    {
        return $this->belongsTo(Role::class)->select(array('id','name'));
    }

    public function job()
    {
        return $this->belongsTo(Job::class)->select(array('id','name'));
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function file()
    {
        return $this->morphOne('App\File', 'fileable');
    }



}
