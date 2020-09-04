<?php

namespace App\Model\Milestones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use SoftDeletes;

    protected $table = 'milestone_statuses';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status'
    ];

    // public function milestones()
    // {
    //     return $this->belongsToMany('App\Model\Milestone', 'milestones', 'user_id', 'role_id');
    // }
}
