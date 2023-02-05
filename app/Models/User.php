<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Status;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;


    protected static function booted()
    {
        parent::boot();

        /**
         * Handle the product "creating" event.
         *
         * @return void
         */
        static::creating(function (User $user) {
            $user->uuid = getUserId();
        });

        static::created(function (User $user) {
            $user->planUser()->create([
                'balance' => 0,
                'plan_id' => 1,
            ]);
        });
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'country_code',
        'mobile',
        'status',
        'uuid',
        'address',
        'sv',
        'ban_reason',
        'created_at',
        'updated_at',
        'email_verified_at',
        'ref_by',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => Status::class
    ];

    public function planUser()
    {
        return $this->hasOne(PlanUser::class);
    }

    public function balance(){
        $user = $this->load('planUser');
        return $user->planUser->balance + $user->planUser->referral_income + $user->planUser->profit_bonus + $user->planUser->referral_deposit + $user->planUser->current_profit;
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'ref_by');
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function withdrawals()
    {
        return $this->hasMany(Payment::class)->where('type', 'debit');
    }
    public function deposits()
    {
        return $this->hasMany(Payment::class)->where('type', 'credit');
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
    public function committees()
    {
        return $this->hasMany(CommitteeUser::class);
    }
    public function commissions()
    {
        return $this->hasMany(CommissionLog::class, 'to_id');
    }

    public function loginLogs(){
        return $this->hasMany(LoginLog::class);
    }
}
