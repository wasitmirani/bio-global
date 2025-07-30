<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\UserNotify;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Collection;

class User extends Authenticatable
{
    use HasApiTokens, UserNotify;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'ver_code', 'balance', 'kyc_data'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'kyc_data' => 'object',
        'ver_code_send_at' => 'datetime'
    ];


    public function loginLogs()
    {
        return $this->hasMany(UserLogin::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('id', 'desc');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class)->where('status', '!=', Status::PAYMENT_INITIATE);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class)->where('status', '!=', Status::PAYMENT_INITIATE);
    }

    public function tickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function refBy()
    {
        return $this->belongsTo(User::class, 'ref_by');
    }

    public function fullname(): Attribute
    {
        return new Attribute(
            get: fn () => $this->firstname . ' ' . $this->lastname,
        );
    }

    public function mobileNumber(): Attribute
    {
        return new Attribute(
            get: fn () => $this->dial_code . $this->mobile,
        );
    }

    // SCOPES
    public function scopeActive($query)
    {
        return $query->where('status', Status::USER_ACTIVE)->where('ev', Status::VERIFIED)->where('sv', Status::VERIFIED);
    }

    public function scopePaidUser($query)
    {
        return $query->where('plan_id', '!=', 0);
    }
    public function scopeFreeUser($query)
    {
        return $query->where('plan_id', 0);
    }

    public function scopeBanned($query)
    {
        return $query->where('status', Status::USER_BAN);
    }

    public function scopeEmailUnverified($query)
    {
        return $query->where('ev', Status::UNVERIFIED);
    }

    public function scopeMobileUnverified($query)
    {
        return $query->where('sv', Status::UNVERIFIED);
    }

    public function scopeKycUnverified($query)
    {
        return $query->where('kv', Status::KYC_UNVERIFIED);
    }

    public function scopeKycPending($query)
    {
        return $query->where('kv', Status::KYC_PENDING);
    }

    public function scopeEmailVerified($query)
    {
        return $query->where('ev', Status::VERIFIED);
    }

    public function scopeMobileVerified($query)
    {
        return $query->where('sv', Status::VERIFIED);
    }

    public function scopeWithBalance($query)
    {
        return $query->where('balance', '>', 0);
    }

    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }

    public function userExtra()
    {
        return $this->hasOne(UserExtra::class);
    }

    // decendants

    public function children()
    {
        return $this->hasMany(User::class, 'ref_by', 'id');
    }
    
      // Relationship to get direct parent
      
      public function parent()
    {
        return $this->belongsTo(User::class, 'ref_by', 'id');
    }

    /**
     * Get all ancestors in proper order (parent -> grandparent -> great-grandparent)
     */
    public function ancestors()
    {
        $ancestors = new Collection();
        $current = $this->parent;

        while ($current) {
            $ancestors->push($current);
            $current = $current->parent;
        }

        return $ancestors;
    }

    /**
     * Get all ancestors with eager loading (more efficient for multiple users)
     */
    public function ancestorsWithEagerLoad()
    {
        return $this->loadMissing(['parent.parent'])->ancestors();
    }

    /**
     * Get ancestors as a flat array with levels
     */
    public function getAncestorsWithLevels()
    {
        $ancestors = [];
        $level = 1;
        $current = $this->parent;

        while ($current) {
            $ancestors[] = [
                'user' => $current,
                'level' => $level++
            ];
            $current = $current->parent;
        }

        return $ancestors;
    }


    public function isAffiliate()
    {
        return $this->registration_type === 'affiliate';
    }
   
 }
