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

    protected $casts = [
        'is_sent' => 'boolean',
        'is_paid' => 'boolean'
    ];

    protected $appends = [
        'status',
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

    public function getStatusAttribute()
    {
        return $this->is_sent ? 'sent' : ($this->is_paid ? 'paid' : 'draft');
    }

    public function getTotalAttribute()
    {
        return round($this->transactions->sum('quantity') * $this->transactions->sum('unit_cost'), 2);
    }

}
