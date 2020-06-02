<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name', 
        'contact_name',
        'contact_email'
    ];

    public function Invoices()
    {
        return $this->hasMany('App\Invoice', 'client_id');
    }
}
