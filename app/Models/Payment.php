<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'parameters' => 'array'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function gateway()
    {
        return $this->belongsTo(Gateway::class);
    }
    public function scopeDeposit($query)
    {
        $query->whereRelation('transactions', 'type', 'credit');
    }

    public function scopeWithdrawal($query)
    {
        $query->whereRelation('transactions', 'type', 'debit');
    }
}
