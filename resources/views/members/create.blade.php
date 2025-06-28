<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Member') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('members.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block">Name</label>
                            <input type="text" name="name" class="border rounded w-full py-2 px-3" value="{{ old('name') }}" required>
                            @error('name') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block">Phone</label>
                            <div class="flex items-center">
                                <span class="inline-block bg-gray-100 border border-r-0 rounded-l px-3 py-2 text-gray-700 select-none">+92</span>
                                <input type="text" id="phone_digits" class="border rounded-r w-full py-2 px-3" maxlength="10" pattern="\d{10}" required placeholder="1234567890" value="{{ old('phone') ? ltrim(old('phone'), '+92') : '' }}">
                                <input type="hidden" name="phone" id="phone_full" value="{{ old('phone', '+92') }}">
                            </div>
                            @error('phone') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block">Membership Start</label>
                            <input type="date" name="membership_start" id="membership_start" class="border rounded w-full py-2 px-3" value="{{ old('membership_start') }}" required>
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
                            <label class="block">Membership End</label>
                            <input type="date" name="membership_end" id="membership_end" class="border rounded w-full py-2 px-3 bg-gray-100 cursor-not-allowed" value="{{ old('membership_end') }}" readonly tabindex="-1" required>
                            @error('membership_end') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block">Amount Paid</label>
                            <input type="number" step="0.01" name="amount_paid" class="border rounded w-full py-2 px-3" value="{{ old('amount_paid') }}" required>
                            @error('amount_paid') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="bg-black text-Black font-bold py-2 px-4 rounded shadow transition transform hover:scale-105 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">Add Member</button>
                        <a href="{{ route('members.index') }}" class="ml-4 inline-block font-bold py-2 px-4 rounded transition transform hover:scale-105 bg-gray-200 text-gray-800 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                const startInput = document.getElementById('membership_start');
                const endInput = document.getElementById('membership_end');
                if (startInput.value) {
                    endInput.value = calculateEndDate(startInput.value, months);
                } else {
                    alert('Please select a membership start date first.');
                }
            });
        });
        // Optionally, clear end date if start date changes
        document.getElementById('membership_start').addEventListener('change', function() {
            document.getElementById('membership_end').value = '';
        });
        // Phone input: combine +92 and digits before submit
        const phoneDigits = document.getElementById('phone_digits');
        const phoneFull = document.getElementById('phone_full');
        if(phoneDigits && phoneFull) {
            phoneDigits.addEventListener('input', function() {
                phoneFull.value = '+92' + this.value;
            });
            // On form submit, ensure hidden input is updated
            phoneDigits.form.addEventListener('submit', function() {
                phoneFull.value = '+92' + phoneDigits.value;
            });
        }
    </script>
</x-app-layout> 