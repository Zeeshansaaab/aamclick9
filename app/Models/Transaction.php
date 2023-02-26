<?php

namespace App\Models;

use Couchbase\Scope;
use App\Enums\Status;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime',
        'status'     => Status::class,
    ];

    protected static function booted()
    {
        parent::boot();

        /**
         * Handle the product "creating" event.
         *
         * @return void
         */
        static::created(function (Transaction $transaction) {
            // $transaction->post_balance = $transaction->user->balance();
            // $transaction->save();
        });
    }


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        $query->whereStatus('active');
    }

    public function withdrawals(){
        return $this->hasMany(Payment::class)->where('type', 'debit');
    }
    public function deposit(){
        return $this->hasMany(Payment::class)->where('type', 'credit');
    }
    public function commissions(){
        return $this->hasMany(CommissionLog::class);
    }
}
