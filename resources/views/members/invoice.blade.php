<!DOCTYPE html>
<html>
<head>
    <title>Invoice - {{ $member->name }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
            font-family: 'Consolas', monospace;
        }
        .header-bar {
            background: linear-gradient(90deg, #ec4899 0%, #3b82f6 100%);
            color: white;
            padding: 2rem 0;
            text-align: center;
            font-size: 2.5rem;
            font-weight: 900;
            letter-spacing: 2px;
            font-family: 'Consolas', monospace;
        }
        h2, .font-bold, .font-semibold {
            font-family: 'Consolas', monospace;
        }
        @media print {
            .no-print { display: none; }
            body { background: white !important; }
        }
    </style>
</head>
<body class="p-8">
    <div class="max-w-2xl mx-auto p-10 relative">
        <!-- Header -->
        <div class="header-bar mb-8">
            Life Fittness Gym
        </div>
        <!-- Invoice Info -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <span class="text-xs text-gray-400">Invoice #{{ $member->id }}</span>
            </div>
            <div class="text-right">
                <span class="text-xs text-gray-400">Invoice Date: <span class="font-semibold text-gray-700">{{ now()->format('Y-m-d') }}</span></span>
            </div>
        </div>
        <!-- Member Info -->
        <div class="mb-6">
            <h2 class="text-lg font-bold mb-2 text-gray-700 border-b pb-1">Member Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                <div><span class="font-semibold">Name:</span> {{ $member->name }}</div>
                <div><span class="font-semibold">Phone:</span> {{ $member->phone }}</div>
                <div><span class="font-semibold">Membership Period:</span> {{ $member->membership_start }} to {{ $member->membership_end }}</div>
            </div>
        </div>
        <!-- Payment Summary -->
        <div class="mb-6">
            <h2 class="text-lg font-bold mb-2 text-gray-700 border-b pb-1">Payment Summary</h2>
            <div class="flex justify-between items-center">
                <span class="font-semibold text-gray-600">Amount Paid:</span>
                <span class="text-2xl font-bold text-pink-600 bg-pink-50 px-4 py-1 rounded shadow">₨{{ number_format($member->amount_paid, 2) }}</span>
            </div>
        </div>
        <!-- Renewal Details -->
        <div class="mb-6">
            <h2 class="text-lg font-bold mb-2 text-gray-700 border-b pb-1">Renewal Details</h2>
            @if($latestRenewal)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <div><span class="font-semibold">Last Renewed By:</span> {{ $latestRenewal->renewed_by }}</div>
                    <div><span class="font-semibold">Renewed At:</span> {{ $latestRenewal->created_at }}</div>
                    <div><span class="font-semibold">Renewal Date:</span> {{ $latestRenewal->renewal_date }}</div>
                </div>
            @else
                <div class="text-gray-500">No renewal record found.</div>
            @endif
        </div>
        <!-- Footer -->
        <div class="mt-10 border-t pt-4 text-center">
            <p class="text-lg font-semibold text-pink-600">Thank you for being a valued member!</p>
            <p class="text-xs text-gray-400 mt-2">This is a system generated invoice and does not require a signature.</p>
        </div>
        <div class="flex justify-between items-center mt-8 no-print">
            <button onclick="window.print()" class="bg-gradient-to-r from-pink-500 to-blue-500 text-white px-8 py-2 rounded font-bold shadow hover:from-pink-600 hover:to-blue-600 transition">Print Invoice</button>
            <a href="{{ route('members.show', $member) }}" class="text-blue-600 hover:underline font-semibold">Back</a>
        </div>
    </div>
</body>
</html> 