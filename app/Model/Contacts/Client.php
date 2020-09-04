<?php

namespace App\Model\Contacts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $table = 'clients';

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

    public function contacts()
    {
        return $this->hasMany('App\Model\Contacts\Contacts', 'client_id', 'id');
    }
}
