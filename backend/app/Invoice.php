<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'reference', 
        'is_paid',
        'is_sent',
        'client_id'
    ];

    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction', 'invoice_id');
    }
}
