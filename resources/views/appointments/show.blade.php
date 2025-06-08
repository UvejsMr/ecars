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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center flex-1">
                {{ __('Appointment Details') }}
            </h2>
            <div class="w-[120px]"></div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8 fade-in">
            <!-- Appointment Status Banner -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border
                {{ $appointment->status === 'pending' ? 'border-yellow-200 bg-yellow-50' : 
                   ($appointment->status === 'confirmed' ? 'border-green-200 bg-green-50' : 
                   ($appointment->status === 'completed' ? 'border-blue-200 bg-blue-50' : 
                   'border-red-200 bg-red-50')) }}">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-full 
                            {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-600' : 
                               ($appointment->status === 'confirmed' ? 'bg-green-100 text-green-600' : 
                               ($appointment->status === 'completed' ? 'bg-blue-100 text-blue-600' : 
                               'bg-red-100 text-red-600')) }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Appointment Status</h3>
                            <p class="text-sm text-gray-600">
                                {{ ucfirst($appointment->status) }} - 
                                {{ $appointment->appointment_date->format('F j, Y') }} at 
                                {{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }}
                            </p>
                        </div>
                    </div>
                    @if($appointment->status === 'pending')
                        <form action="{{ route('appointments.cancel', $appointment) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white text-sm rounded-lg font-semibold shadow hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 transition"
                                    onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Cancel Appointment
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Car Information -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border">
                <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                    </svg>
                    Car Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-start gap-4">
                        @if($appointment->car->images->count() > 0)
                            <img src="{{ Storage::url($appointment->car->images->first()->image_path) }}" 
                                 alt="{{ $appointment->car->make }} {{ $appointment->car->model }}" 
                                 class="w-24 h-24 rounded-lg object-cover border">
                        @else
                            <div class="w-24 h-24 rounded-lg bg-gray-100 flex items-center justify-center">
                                <span class="text-3xl">🚗</span>
                            </div>
                        @endif
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $appointment->car->make }} {{ $appointment->car->model }}</h4>
                            <p class="text-sm text-gray-600">{{ $appointment->car->year }}</p>
                            <p class="text-sm text-gray-600">{{ number_format($appointment->car->mileage) }} miles</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm text-gray-600">VIN: <span class="font-medium text-gray-900">{{ $appointment->car->vin }}</span></p>
                        <p class="text-sm text-gray-600">Color: <span class="font-medium text-gray-900">{{ $appointment->car->color }}</span></p>
                        <p class="text-sm text-gray-600">Transmission: <span class="font-medium text-gray-900">{{ $appointment->car->transmission }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Servicer Information -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border">
                <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Servicer Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-start gap-4">
                        @if($appointment->servicer->logo)
                            <img src="{{ Storage::url($appointment->servicer->logo) }}" 
                                 alt="{{ $appointment->servicer->company_name }}" 
                                 class="w-16 h-16 rounded-lg object-cover border">
                        @else
                            <div class="w-16 h-16 rounded-lg bg-gray-100 flex items-center justify-center text-2xl font-bold text-gray-400">
                                {{ substr($appointment->servicer->company_name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $appointment->servicer->company_name }}</h4>
                            <p class="text-sm text-gray-600">{{ $appointment->servicer->user->name }}</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm text-gray-600 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ $appointment->servicer->user->email }}
                        </p>
                        <p class="text-sm text-gray-600 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ $appointment->servicer->phone_number }}
                        </p>
                        <p class="text-sm text-gray-600 flex items-start gap-2">
                            <svg class="w-4 h-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $appointment->servicer->address }}
                        </p>
                    </div>
                </div>
            </div>

            @if($appointment->notes)
            <!-- Notes Section -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border">
                <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Additional Notes
                </h3>
                <p class="text-gray-700">{{ $appointment->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        // Add fade-in animation
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    element.style.transition = 'all 0.5s ease-out';
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
    @endpush
</x-app-layout> 