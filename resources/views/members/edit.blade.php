<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Member') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('members.update', $member) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block">Name</label>
                            <input type="text" name="name" class="border rounded w-full py-2 px-3" value="{{ old('name', $member->name) }}" required>
                            @error('name') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block">Phone</label>
                            <div class="flex max-w-xs mx-auto rounded-lg overflow-hidden border focus-within:ring-2 focus-within:ring-blue-400">
                                <span class="flex items-center px-3 bg-gray-100 text-gray-500 select-none border-r">+92</span>
                                <input type="text" name="phone" maxlength="10" pattern="\d{10}" class="flex-1 py-2 px-3 outline-none bg-white text-gray-900" value="{{ old('phone', ltrim($member->phone, '+92')) }}" required placeholder="3XXXXXXXXX">
                            </div>
                            <div class="text-xs text-gray-500 mt-1">Phone must be 10 digits after +92</div>
                            @error('phone') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block">Membership Start</label>
                            <input type="date" name="membership_start" class="border rounded w-full py-2 px-3" value="{{ old('membership_start', $member->membership_start) }}" required>
                            @error('membership_start') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block">Membership End</label>
                            <input type="date" name="membership_end" class="border rounded w-full py-2 px-3" value="{{ old('membership_end', $member->membership_end) }}" required>
                            @error('membership_end') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block">Amount Paid</label>
                            <input type="number" step="0.01" name="amount_paid" class="border rounded w-full py-2 px-3" value="{{ old('amount_paid', $member->amount_paid) }}" required>
                            @error('amount_paid') <div class="text-red-600">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="bg-black text-black font-bold py-2 px-4 rounded shadow transition transform hover:scale-105 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">Update Member</button>
                        <a href="{{ route('members.index') }}" class="ml-4 inline-block font-bold py-2 px-4 rounded transition transform hover:scale-105 bg-gray-200 text-gray-800 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 