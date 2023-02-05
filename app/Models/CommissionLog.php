<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionLog extends Model
{
    use HasFactory;

    protected $fillable = ['to_id', 'from_id', 'level', 'transaction_id', 'created_at', 'updated_at'];
 
    public function from(){
        return $this->belongsTo(User::class, 'from_id');
    }
    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }
}
