<?php

namespace App\Model\Milestones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cost extends Model
{
    // use SoftDeletes;

    protected $table = 'milestone_costs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price_per',
        'quantity',
        'total_cost',
        'project_id',
        'milesone_id'
    ];
}
