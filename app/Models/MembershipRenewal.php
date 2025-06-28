<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipRenewal extends Model
{
    protected $fillable = [
        'member_id',
        'renewal_date',
        'membership_start',
        'membership_end',
        'amount_paid',
        'renewed_by',
    ];

    public function member()
    {
        return $this->belongsTo(\App\Models\Member::class);
    }
}
