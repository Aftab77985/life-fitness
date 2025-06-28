<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Member Details: ') . $member->name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Member Info</h3>
                <p><strong>Name:</strong> {{ $member->name }}</p>
                <p><strong>Phone:</strong> {{ $member->phone }}</p>
                <p><strong>Current Membership:</strong> {{ $member->membership_start }} to {{ $member->membership_end }}</p>
                <p><strong>Amount Paid:</strong> ₨{{ number_format($member->amount_paid, 2) }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6 mt-6">
                <h3 class="text-lg font-bold mb-4">Renewal History</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Renewal Date</th>
                            <th class="px-4 py-2">Membership Start</th>
                            <th class="px-4 py-2">Membership End</th>
                            <th class="px-4 py-2">Amount Paid</th>
                            <th class="px-4 py-2">Renewed By</th>
                            <th class="px-4 py-2">Renewed At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($renewals as $renewal)
                            <tr>
                                <td class="px-4 py-2">{{ $renewal->renewal_date }}</td>
                                <td class="px-4 py-2">{{ $renewal->membership_start }}</td>
                                <td class="px-4 py-2">{{ $renewal->membership_end }}</td>
                                <td class="px-4 py-2">₨{{ number_format($renewal->amount_paid, 2) }}</td>
                                <td class="px-4 py-2">{{ $renewal->renewed_by }}</td>
                                <td class="px-4 py-2">{{ $renewal->created_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-2 text-center text-gray-500">No renewals yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <a href="{{ route('members.invoice', $member) }}" class="inline-block mt-4 bg-pink-700 text-white px-4 py-2 rounded hover:bg-pink-800 transition">Print Invoice</a>
        </div>
    </div>
</x-app-layout> 