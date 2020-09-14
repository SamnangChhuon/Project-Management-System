<?php

namespace App\Model\Milestones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hour extends Model
{
    use SoftDeletes;

    protected $table = 'milestone_hours';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'time',
        'work_completed',
        'task_id',
        'project_id',
        'employee_id'
    ];
}
