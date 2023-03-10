<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
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
        static::creating(function (Plan $plan) {
            $plan->uuid = Str::uuid();
        });
    }

    public function plans()
    {
        return $this->hasMany(Plan::class, 'parent_id');
    }
    public function category()
    {
        return $this->belongsTo(Plan::class, 'parent_id');
    }

    public function members()
    {
        return $this->hasMany(CommitteeUser::class, 'plan_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function levels(){
        return $this->hasMany(PlanLevel::class);
    }
    public function scopeDefault($query)
    {
        $query->whereType('default');
    }
    public function scopeCommittee($query)
    {
        $query->whereType('committee');
    }
    public function scopeReward($query)
    {
        $query->whereType('reward');
    }
    public function scopeUmrah($query)
    {
        $query->whereType('umrah');
    }
    public function scopeActive($query)
    {
        $query->whereStatus('active');
    }
    public function scopeParent($query)
    {
        $query->whereNull('parent_id');
    }
}
