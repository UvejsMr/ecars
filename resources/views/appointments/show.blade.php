<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <a href="{{ route('appointments.index') }}" class="inline-flex items-center gap-2 px-5 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg shadow hover:bg-gray-300 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Appointments
                </a>
            </div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Appointment Details') }}
            </h2>
            <div></div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8 fade-in">
            <!-- Appointment Info Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border">
                <h3 class="text-lg font-semibold mb-4">Appointment Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @if($appointment->status === 'confirmed') bg-green-100 text-green-800
                            @elseif($appointment->status === 'completed') bg-blue-100 text-blue-800
                            @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Date</p>
                        <p class="font-medium">{{ $appointment->appointment_date->format('F j, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Time</p>
                        <p class="font-medium">{{ $appointment->start_time }} - {{ $appointment->end_time }}</p>
                    </div>
                    @if($appointment->notes)
                    <div>
                        <p class="text-sm text-gray-600">Notes</p>
                        <p class="font-medium">{{ $appointment->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Car Info Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border">
                <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" /></svg>
                    Car Information
                </h3>
                <div class="flex items-center gap-4 mb-4">
                    @if($appointment->car->images->count() > 0)
                        <img src="{{ Storage::url($appointment->car->images->first()->image_path) }}" alt="Car" class="w-20 h-20 rounded-lg object-cover border">
                    @else
                        <span class="w-20 h-20 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 text-3xl">🚗</span>
                    @endif
                    <div>
                        <div class="font-bold text-lg text-gray-900">{{ $appointment->car->make }} {{ $appointment->car->model }}</div>
                        <div class="flex flex-wrap gap-2 mt-1">
                            <span class="inline-block px-2 py-0.5 rounded bg-blue-100 text-blue-700 text-xs font-semibold">{{ $appointment->car->year }}</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Year</p>
                        <p class="font-medium">{{ $appointment->car->year }}</p>
                    </div>
                </div>
            </div>

            <!-- Servicer Info Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border">
                <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    Servicer Information
                </h3>
                <div class="flex items-center gap-4 mb-4">
                    @if($appointment->servicer->logo)
                        <img src="{{ Storage::url($appointment->servicer->logo) }}" alt="Logo" class="w-20 h-20 rounded-full object-cover border">
                    @else
                        <span class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-3xl">{{ substr($appointment->servicer->company_name, 0, 1) }}</span>
                    @endif
                    <div>
                        <div class="font-bold text-lg text-gray-900">{{ $appointment->servicer->company_name ?? $appointment->servicer->user->name }}</div>
                        <div class="text-xs text-gray-500">Servicer</div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Name</p>
                        <p class="font-medium">{{ $appointment->servicer->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-medium">{{ $appointment->servicer->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Phone</p>
                        <p class="font-medium">{{ $appointment->servicer->phone_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Address</p>
                        <p class="font-medium">{{ $appointment->servicer->address }}</p>
                    </div>
                </div>
            </div>

            @if($appointment->status === 'pending')
            <div class="fade-in">
                <form action="{{ route('appointments.cancel', $appointment) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-red-600 text-white font-semibold rounded-lg shadow hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Cancel Appointment
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        // Add fade-in animation to cards
        document.addEventListener('DOMContentLoaded', function() {
            const fadeEls = document.querySelectorAll('.fade-in');
            fadeEls.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    el.style.transition = 'all 0.5s ease-out';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
    @endpush
</x-app-layout> 