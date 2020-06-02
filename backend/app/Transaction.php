<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'quantity', 
        'unit',
        'description',
        'unit_cost',
        'invoice_id'
    ];

    public function invoice()
    {
        return $this->belongsTo('App\Invoice', 'invoice_id');
    }
}
