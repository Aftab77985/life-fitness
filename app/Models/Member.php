<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'membership_start',
        'membership_end',
        'amount_paid',
    ];

    public function renewals()
    {
        return $this->hasMany(\App\Models\MembershipRenewal::class);
    }

}
