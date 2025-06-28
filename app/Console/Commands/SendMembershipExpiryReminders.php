<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;
use App\Services\SendPkSmsService;

class SendMembershipExpiryReminders extends Command
{
    protected $signature = 'members:send-expiry-reminders';
    protected $description = 'Send SMS reminders to members whose membership is about to expire in 3, 2, or 1 day(s)';

    public function handle()
    {
        $today = now();
        $daysLeftArray = [3, 2, 1];

        foreach ($daysLeftArray as $daysLeft) {
            $targetDate = $today->copy()->addDays($daysLeft)->toDateString();

            $members = Member::whereDate('membership_end', $targetDate)->get();

            foreach ($members as $member) {
                $message = "Dear {$member->name}, your Life Fitness Gym membership will expire in {$daysLeft} day" . ($daysLeft > 1 ? 's' : '') . ". Please renew to continue enjoying our services!";
                app(SendPkSmsService::class)->send($member->phone, $message);
            }
        }

        $this->info('Membership expiry reminders sent.');
    }
} 