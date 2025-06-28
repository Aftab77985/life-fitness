<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Members') }}
        </h2>
    </x-slot>
    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <span class="text-lg font-semibold">Total Members: </span>
                    <span class="text-blue-700 font-bold">{{ $members->count() }}</span>
                    <span class="ml-6 text-lg font-semibold">Total Paid: </span>
                    <span class="text-green-700 font-bold">₨{{ number_format($members->sum('amount_paid'), 2) }}</span>
                </div>
                <a href="{{ route('members.create') }}" class="bg-black hover:bg-gray-800 text-black font-bold py-2 px-4 rounded shadow transition">+ Add Member</a>
            </div>
            @if(!request('search'))
            <div x-data="{ open: false, search: '', suggestions: [], allMembers: [
                @foreach($members as $member)
                    { name: @js($member->name), phone: @js($member->phone) },
                @endforeach
            ],
                filterSuggestions() {
                    if (this.search.length === 0) {
                        this.suggestions = [];
                        return;
                    }
                    const term = this.search.toLowerCase();
                    this.suggestions = this.allMembers.filter(m =>
                        m.name.toLowerCase().includes(term) || m.phone.toLowerCase().includes(term)
                    ).slice(0, 5);
                },
                selectSuggestion(s) {
                    this.search = s.name;
                    this.suggestions = [];
                    $refs.searchInput.value = s.name;
                    $el.closest('form').submit();
                }
            }" class="mb-4 flex flex-col sm:flex-row gap-2 items-start sm:items-center relative">
                <button type="button" x-show="!open" @click="open = true; $nextTick(() => $refs.searchInput.focus())" class="flex items-center justify-center w-10 h-10 bg-blue-500 hover:bg-blue-700 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" /></svg>
                </button>
                <form method="GET" action="{{ route('members.index') }}" @submit.prevent="if(search) $el.submit()" :class="{'block': open, 'hidden': !open}" class="w-full sm:w-auto transition-all duration-300" style="min-width: 0;">
                    <div class="relative flex items-center gap-2">
                        <input x-ref="searchInput" x-model="search" @input="filterSuggestions" name="search" type="text" placeholder="Search by name or phone" class="border rounded py-2 pl-3 pr-3 w-full focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200" autocomplete="off" />
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-1 px-3 rounded transition">Go</button>
                        <template x-if="search">
                            <a href="{{ route('members.index') }}" class="ml-2 text-gray-600 hover:text-red-600 font-semibold transition" @click.prevent="search = ''; suggestions = []; open = false">Clear</a>
                        </template>
                    </div>
                    <div x-show="suggestions.length > 0" class="absolute z-10 bg-white border rounded shadow mt-1 w-full max-w-xs">
                        <template x-for="s in suggestions" :key="s.name + s.phone">
                            <div @click="selectSuggestion(s)" class="px-4 py-2 cursor-pointer hover:bg-blue-100">
                                <span x-text="s.name"></span> <span class="text-gray-400 text-xs ml-2" x-text="s.phone"></span>
                            </div>
                        </template>
                    </div>
                </form>
            </div>
            @endif
            @if(request('search'))
                <div class="mb-4">
                    <a href="{{ route('members.index') }}" class="inline-block bg-gray-200 hover:bg-red-400 text-gray-800 hover:text-white font-bold py-2 px-4 rounded transition">Clear Search</a>
                </div>
            @endif
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="mb-4 font-medium text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 consolas-table">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Name</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Phone</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Membership Start</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Membership End</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Amount Paid</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Days Left</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($members as $member)
                                    @php
                                        $daysLeft = $member->days_left;
                                        $rowClass = ($daysLeft <= 3 && $daysLeft >= 0) ? 'bg-red-100 animate-pulse' : ($loop->even ? 'bg-gray-50' : '');
                                    @endphp
                                    <tr class="hover:bg-blue-50 transition {{ $rowClass }}">
                                        <td class="px-4 py-2 font-semibold flex items-center gap-2">
                                            {{ $member->name }}
                                        </td>
                                        <td class="px-4 py-2">{{ $member->phone }}</td>
                                        <td class="px-4 py-2">{{ $member->membership_start }}</td>
                                        <td class="px-4 py-2">{{ $member->membership_end }}</td>
                                        <td class="px-4 py-2 text-green-700 font-bold">₨{{ number_format($member->amount_paid, 2) }}</td>
                                        <td class="px-4 py-2 font-bold">
                                            @if($daysLeft < 0)
                                                <span class="text-red-600">Membership ended on {{ \Carbon\Carbon::parse($member->membership_end)->format('Y-m-d') }}</span>
                                            @elseif($daysLeft === 0)
                                                <span class="text-yellow-600">Expires today</span>
                                            @else
                                                <span class="{{ $daysLeft <= 3 ? 'text-red-600' : 'text-gray-800' }}">{{ $daysLeft }} day{{ $daysLeft == 1 ? '' : 's' }} left</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            <a href="{{ route('members.show', $member) }}" class="text-indigo-700 hover:underline font-semibold">View</a>
                                            <a href="{{ route('members.edit', $member) }}" class="ml-2 text-blue-600 hover:underline font-semibold">Edit</a>
                                            <a href="{{ route('members.renew', $member) }}" class="ml-2 text-green-700 hover:underline font-semibold">Renew</a>
                                            <form action="{{ route('members.destroy', $member) }}" method="POST" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline ml-2 font-semibold" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                            <form action="{{ route('members.sendSms', $member->id) }}" method="POST" style="display:inline">
                                                @csrf
                                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-black px-3 py-1 rounded ml-2" onclick="return confirm('Send SMS to this member?')">
                                                    Send SMS
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .consolas-table, .consolas-table * {
            font-family: 'Consolas', monospace !important;
        }
    </style>
</x-app-layout> 