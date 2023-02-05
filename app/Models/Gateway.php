<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gateway extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected static function booted()
    {
        parent::boot();

        /**
         * Handle the product "creating" event.
         *
         * @return void
         */
        static::creating(function (Gateway $gateway) {
            $gateway->slug = Str::slug($gateway->name);
        });
    }

    protected $casts = [
        'gateway_parameters' => 'array'
    ];

    public function scopeDeposit($query)
    {
        $query->where('type', 'deposit')->orWhere('type', 'both')->active();
    }

    public function scopeWithdrawal($query)
    {
        $query->where('type', 'withdrawal')->orWhere('type', 'both')->active();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function scopeActive($query){
        $query->whereStatus('active');
    }
}
