<?php

namespace App\Model\Contacts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    protected $table = 'contacts';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'title',
        'first_name',
        'middle',
        'last_name',
        'email',
        'email_verified_at',
        'gender',
        'occupation',
        'phone',
        'birthday',
        'notes',
        'client_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public function contact()
    {
        return $this->hasOne('App\Model\Contacts\Client', 'id', 'client_id');
    }
}
