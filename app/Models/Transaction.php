<?php

namespace App\Models;

use App\Enums\Status;
use Couchbase\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime',
        'status'     => Status::class,
    ];

    public function scopeActive($query)
    {
        $query->whereStatus('active');
    }
}
