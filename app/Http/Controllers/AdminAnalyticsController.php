<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAnalyticsController extends Controller
{
    public function index()
    {
        $totalRevenue = \App\Models\Member::sum('amount_paid') + \App\Models\MembershipRenewal::sum('amount_paid');
        $newMembersThisMonth = \App\Models\Member::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $renewalsThisMonth = \App\Models\MembershipRenewal::whereMonth('renewal_date', now()->month)->whereYear('renewal_date', now()->year)->count();
        $totalMembers = \App\Models\Member::count();
        $activeMembers = \App\Models\Member::where('membership_end', '>=', now()->toDateString())->count();
        $totalRenewals = \App\Models\MembershipRenewal::count();

        // Chart: New Members per Month (last 12 months)
        $membersPerMonth = \App\Models\Member::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Chart: Revenue per Month (last 12 months)
        $memberRevenue = \App\Models\Member::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(amount_paid) as revenue')
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
        $renewalRevenue = \App\Models\MembershipRenewal::selectRaw('YEAR(renewal_date) as year, MONTH(renewal_date) as month, SUM(amount_paid) as revenue')
            ->where('renewal_date', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Merge revenue data
        $revenuePerMonth = [];
        foreach ($memberRevenue as $row) {
            $key = $row->year.'-'.$row->month;
            $revenuePerMonth[$key] = $row->revenue;
        }
        foreach ($renewalRevenue as $row) {
            $key = $row->year.'-'.$row->month;
            if (isset($revenuePerMonth[$key])) {
                $revenuePerMonth[$key] += $row->revenue;
            } else {
                $revenuePerMonth[$key] = $row->revenue;
            }
        }
        ksort($revenuePerMonth);

        // Format chart data for Blade
        $chartLabels = [];
        $chartMembers = [];
        $chartRevenue = [];
        $months = collect(range(0, 11))->map(function($i) {
            return now()->subMonths(11 - $i);
        });
        foreach ($months as $date) {
            $label = $date->format('M Y');
            $year = $date->year;
            $month = $date->month;
            $chartLabels[] = $label;
            $members = $membersPerMonth->firstWhere('year', $year)?->month == $month ? $membersPerMonth->firstWhere('year', $year)?->count : 0;
            $chartMembers[] = $members;
            $key = $year.'-'.$month;
            $chartRevenue[] = $revenuePerMonth[$key] ?? 0;
        }

        return view('admin.analytics', compact(
            'totalRevenue',
            'newMembersThisMonth',
            'renewalsThisMonth',
            'totalMembers',
            'activeMembers',
            'totalRenewals',
            'chartLabels',
            'chartMembers',
            'chartRevenue'
        ));
    }
} 