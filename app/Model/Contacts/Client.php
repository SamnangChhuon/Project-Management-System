<?php

namespace App\Model\Contacts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'website',
        'industry',
        'revenue',
        'description',
        'phone',
        'street1',
        'street2',
        'city',
        'state',
        'zip',
        'country',
        'notes'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];
}
