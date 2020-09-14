<?php

namespace App\Model\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_name',
        'instructions',
        'total_hours',
        'status_id',
        'milestone_id',
        'project_id',
        'employee_id'
    ];
}
