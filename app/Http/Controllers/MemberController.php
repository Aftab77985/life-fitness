<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Services\SendPkSmsService;
use Carbon\Carbon;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Member::query();
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
            });
        }
        $members = $query->orderBy('created_at', 'desc')->get();
        $members = $members->map(function ($member) {
            $daysLeftRaw = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($member->membership_end), false);
            $member->days_left = (int) $daysLeftRaw;
            return $member;
        })->sortBy('days_left');
        return view('members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'regex:/^\+92\d{10}$/'],
            'membership_start' => 'required|date',
            'membership_end' => 'required|date|after_or_equal:membership_start',
            'amount_paid' => 'required|numeric|min:0',
        ]);
        if (Member::where('phone', $validated['phone'])->exists()) {
            return redirect()->back()->withInput()->withErrors(['phone' => 'A member with this phone number already exists.']);
        }
        Member::create($validated);
        return redirect()->route('members.index')->with('success', 'Member added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        $renewals = $member->renewals()->orderBy('renewal_date', 'desc')->get();
        return view('members.show', compact('member', 'renewals'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'regex:/^\+92\d{10}$/'],
            'membership_start' => 'required|date',
            'membership_end' => 'required|date|after_or_equal:membership_start',
            'amount_paid' => 'required|numeric|min:0',
        ]);
        if (Member::where('phone', $validated['phone'])->where('id', '!=', $member->id)->exists()) {
            return redirect()->back()->withInput()->withErrors(['phone' => 'A member with this phone number already exists.']);
        }
        $member->update($validated);
        return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }

    public function renew(Member $member)
    {
        return view('members.renew', compact('member'));
    }

    public function renewStore(Request $request, Member $member)
    {
        $validated = $request->validate([
            'membership_start' => 'required|date',
            'membership_end' => 'required|date|after_or_equal:membership_start',
            'amount_paid' => 'required|numeric|min:0',
        ]);

        // Update the member's current membership
        $member->update([
            'membership_start' => $validated['membership_start'],
            'membership_end' => $validated['membership_end'],
            'amount_paid' => $validated['amount_paid'],
        ]);

        // Add to renewal history
        \App\Models\MembershipRenewal::create([
            'member_id' => $member->id,
            'renewal_date' => now(),
            'membership_start' => $validated['membership_start'],
            'membership_end' => $validated['membership_end'],
            'amount_paid' => $validated['amount_paid'],
            'renewed_by' => auth()->user()->name,
        ]);

        return redirect()->route('members.index')->with('success', 'Membership renewed successfully.');
    }

    public function invoice(Member $member)
    {
        $latestRenewal = $member->renewals()->latest('renewal_date')->first();
        return view('members.invoice', compact('member', 'latestRenewal'));
    }

    public function sendSms($id, SendPkSmsService $sms)
    {
        $member = Member::findOrFail($id);
        $daysLeft = Carbon::now()->diffInDays(Carbon::parse($member->membership_end), false);
        $message = "Dear {$member->name}, your Life Fitness Gym membership will expire in {$daysLeft} day" . ($daysLeft == 1 ? '' : 's') . ". Please renew to continue enjoying our services!";
        $sms->send($member->phone, $message);
        return back()->with('success', 'SMS sent to member!');
    }
}
