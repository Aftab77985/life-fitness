<x-app-layout>
    <div class="max-w-3xl mx-auto p-6">
        <div class="bg-white rounded-2xl shadow-2xl p-6">
            @if(session('success'))
                <div class="mb-4 px-4 py-3 rounded bg-green-100 text-green-800 font-semibold border border-green-200">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 px-4 py-3 rounded bg-red-100 text-red-800 font-semibold border border-red-200">
                    {{ session('error') }}
                </div>
            @endif
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Staff Members</h1>
                <a href="{{ route('admin.staff.create') }}" class="bg-green-600 hover:bg-green-700 text-black px-4 py-2 rounded-lg font-semibold shadow transition">
                    + Add Staff
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left font-mono border border-gray-200 shadow-lg rounded-xl">
                    <thead class="bg-gray-900 text-black">
                        <tr>
                            <th class="px-6 py-3 rounded-tl-xl">Name</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3 rounded-tr-xl">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staff as $member)
                        <tr class="odd:bg-gray-100 even:bg-gray-50 hover:bg-blue-50 transition">
                            <td class="px-6 py-4 font-semibold flex items-center gap-3">
                                <!-- Avatar with initials -->
                                <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gradient-to-br from-blue-400 to-blue-700 text-white font-bold text-lg shadow">
                                    {{ strtoupper(collect(explode(' ', $member->name))->map(fn($n) => $n[0])->implode('')) }}
                                </span>
                                {{ $member->name }}
                            </td>
                            <td class="px-6 py-4">{{ $member->email }}</td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('admin.staff.edit', $member->id) }}" title="Edit" class="text-blue-600 hover:text-blue-800 font-bold flex items-center">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2h6v6H7v-6z"/></svg>
                                    Edit
                                </a>
                                <form action="{{ route('admin.staff.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Delete this staff member?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Delete" class="text-red-600 hover:text-red-800 font-bold flex items-center">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">No staff members found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout> 