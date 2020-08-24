<?php

namespace App\Model\Milestones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Milestone extends Model
{
    use SoftDeletes;

    protected $table = 'milestones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'due_date',
        'deliverables',
        'status_id',
        'project_id',
        'total_hours'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['due_date', 'deleted_at', 'created_at', 'updated_at'];

}
