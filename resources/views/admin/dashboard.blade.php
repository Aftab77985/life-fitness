<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12 overflow-x-auto bg-gray-900">
    <div class="min-w-[1100px] flex gap-6 px-6">
        <!-- Members -->
        <a href="{{ route('members.index') }}" class="w-64 bg-gray-800 hover:bg-blue-600 transition rounded-2xl shadow-md p-6 flex flex-col items-center text-center text-white group">
            <div class="w-14 h-14 mb-4 flex items-center justify-center bg-blue-500 rounded-full">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 14c1.657 0 3 1.343 3 3v3H5v-3c0-1.657 1.343-3 3-3h8zM12 11a4 4 0 100-8 4 4 0 000 8z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold group-hover:text-white">Members</h3>
            <p class="text-sm text-gray-300 mt-1">View and manage all gym members</p>
        </a>

        <!-- Analytics -->
        <a href="{{ route('admin.analytics') }}" class="w-64 bg-gray-800 hover:bg-pink-600 transition rounded-2xl shadow-md p-6 flex flex-col items-center text-center text-white group">
            <div class="w-14 h-14 mb-4 flex items-center justify-center bg-pink-500 rounded-full">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h4m0 0V7m0 4l-4-4m0 0l-4 4" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold group-hover:text-white">Analytics</h3>
            <p class="text-sm text-gray-300 mt-1">View gym analytics and charts</p>
        </a>

        <!-- Add Staff -->
        <a href="{{ route('admin.staff.create') }}" class="w-64 bg-gray-800 hover:bg-green-600 transition rounded-2xl shadow-md p-6 flex flex-col items-center text-center text-white group">
            <div class="w-14 h-14 mb-4 flex items-center justify-center bg-green-500 rounded-full">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold group-hover:text-white">Add Staff</h3>
            <p class="text-sm text-gray-300 mt-1">Register a new staff login</p>
        </a>

        <!-- Manage Staff -->
        <a href="{{ route('admin.staff.index') }}" class="w-64 bg-gray-800 hover:bg-yellow-600 transition rounded-2xl shadow-md p-6 flex flex-col items-center text-center text-white group">
            <div class="w-14 h-14 mb-4 flex items-center justify-center bg-yellow-500 rounded-full">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold group-hover:text-white">Manage Staff</h3>
            <p class="text-sm text-gray-300 mt-1">View, edit, or delete staff members</p>
        </a>
    </div>
</div>




</x-app-layout> 