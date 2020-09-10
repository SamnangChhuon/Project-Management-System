<?php

namespace App\Model\Projects;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $table = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_name',
        'hourly_rate',
        'budget',
        'active',
        'total_hours',
        'labor_costs',
        'material_costs',
        'total_costs',
        'project_manager_id',
        'status_id',
        'client_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
