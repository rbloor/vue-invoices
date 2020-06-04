<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'reference', 
        'status',
        'client_id'
    ];

    protected $casts = [];

    protected $appends = [
        'total'
    ];

    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction', 'invoice_id');
    }

    public function getTotalAttribute()
    {
        return round($this->transactions->sum('quantity') * $this->transactions->sum('unit_cost'), 2);
    }

}
