<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Renew Membership for ') . $member->name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('members.renew.store', $member) }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block">Name</label>
                            <input type="text" class="border rounded w-full py-2 px-3 bg-gray-100" value="{{ $member->name }}" readonly>
                        </div>
                        <div class="mb-4">
                            <label class="block">Phone</label>
                            <input type="text" class="border rounded w-full py-2 px-3 bg-gray-100" value="{{ $member->phone }}" readonly>
                        </div>
                        <div class="mb-4">
                            <label class="block">New Membership Start</label>
                            <input type="date" name="membership_start" class="border rounded w-full py-2 px-3" value="{{ old('membership_start', now()->toDateString()) }}" required>
                            @error('membership_start') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2">Membership Duration</label>
                            <div class="flex gap-2">
                                <button type="button" class="duration-btn bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded" data-months="1">1 Month</button>
                                <button type="button" class="duration-btn bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded" data-months="2">2 Months</button>
                                <button type="button" class="duration-btn bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded" data-months="3">3 Months</button>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block">New Membership End</label>
                            <input type="date" name="membership_end" id="membership_end" class="border rounded w-full py-2 px-3 bg-gray-100 cursor-not-allowed" value="{{ old('membership_end') }}" readonly tabindex="-1" required>
                            @error('membership_end') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block">Amount Paid</label>
                            <input type="number" step="0.01" name="amount_paid" class="border rounded w-full py-2 px-3" value="{{ old('amount_paid') }}" required>
                            @error('amount_paid') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="bg-black text-black font-bold py-2 px-4 rounded shadow transition transform hover:scale-105 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">Renew Membership</button>
                        <a href="{{ route('members.index') }}" class="ml-4 inline-block font-bold py-2 px-4 rounded transition transform hover:scale-105 bg-gray-200 text-gray-800 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
function calculateEndDate(startDate, months) {
    if (!startDate) return '';
    let date = new Date(startDate);
    date.setMonth(date.getMonth() + months);
    // Handle month overflow
    if (date.getDate() !== new Date(startDate).getDate()) {
        date.setDate(0);
    }
    const yyyy = date.getFullYear();
    const mm = String(date.getMonth() + 1).padStart(2, '0');
    const dd = String(date.getDate()).padStart(2, '0');
    return `${yyyy}-${mm}-${dd}`;
}
document.querySelectorAll('.duration-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const months = parseInt(this.getAttribute('data-months'));
        const startInput = document.querySelector('input[name=membership_start]');
        const endInput = document.getElementById('membership_end');
        if (startInput.value) {
            endInput.value = calculateEndDate(startInput.value, months);
        } else {
            alert('Please select a new membership start date first.');
        }
    });
});
document.querySelector('input[name=membership_start]').addEventListener('change', function() {
    document.getElementById('membership_end').value = '';
});
</script> 