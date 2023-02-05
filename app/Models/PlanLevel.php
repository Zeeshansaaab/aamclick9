<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanLevel extends Model
{
    use HasFactory;

    protected $fillable = ['level', 'percentage', 'type', 'status', 'created_at', 'updated_at', 'plan_id'];
}
