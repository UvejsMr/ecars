<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg shadow hover:bg-gray-300 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Dashboard
                </a>
            </div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center flex-1">
                {{ __('My Appointments') }}
            </h2>
            <div class="w-[120px]"></div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    @if($appointments->isEmpty())
                        <div class="flex flex-col items-center justify-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-500 text-center mb-4">You don't have any appointments yet.</p>
                            <a href="{{ route('appointments.create') }}" class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Book your first appointment
                            </a>
                        </div>
                    @else
                        <!-- Responsive Table for md+ screens -->
                        <div class="hidden md:block fade-in">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-blue-50 sticky top-0 z-10">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Time</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Servicer</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Car</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($appointments as $appointment)
                                            <tr class="hover:bg-blue-50 transition-colors duration-150 even:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->appointment_date->format('M d, Y') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->start_time }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap flex items-center gap-2">
                                                    @if($appointment->servicer->logo)
                                                        <img src="{{ Storage::url($appointment->servicer->logo) }}" alt="Logo" class="w-8 h-8 rounded-full object-cover border">
                                                    @else
                                                        <span class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">{{ substr($appointment->servicer->company_name, 0, 1) }}</span>
                                                    @endif
                                                    <span>{{ $appointment->servicer->company_name }}</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap flex items-center gap-2">
                                                    @if($appointment->car->images->count() > 0)
                                                        <img src="{{ Storage::url($appointment->car->images->first()->image_path) }}" alt="Car" class="w-8 h-8 rounded object-cover border">
                                                    @else
                                                        <span class="w-8 h-8 rounded bg-gray-100 flex items-center justify-center text-gray-400">🚗</span>
                                                    @endif
                                                    <span>{{ $appointment->car->make }} {{ $appointment->car->model }}</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                        @if($appointment->status === 'confirmed') bg-green-100 text-green-800
                                                        @elseif($appointment->status === 'completed') bg-blue-100 text-blue-800
                                                        @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                                                        @else bg-gray-100 text-gray-800
                                                        @endif">
                                                        {{ ucfirst($appointment->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                                    <a href="{{ route('appointments.show', $appointment) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs rounded-lg font-semibold shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                                        View
                                                    </a>
                                                    @if($appointment->status === 'pending')
                                                        <form action="{{ route('appointments.cancel', $appointment) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-xs rounded-lg font-semibold shadow hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 transition" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                                Cancel
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Card View for mobile screens -->
                        <div class="md:hidden fade-in space-y-6">
                            @foreach($appointments as $appointment)
                                <div class="bg-white rounded-2xl shadow-lg border p-5 flex flex-col gap-3">
                                    <div class="flex items-center gap-3">
                                        @if($appointment->servicer->logo)
                                            <img src="{{ Storage::url($appointment->servicer->logo) }}" alt="Logo" class="w-10 h-10 rounded-full object-cover border">
                                        @else
                                            <span class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">{{ substr($appointment->servicer->company_name, 0, 1) }}</span>
                                        @endif
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $appointment->servicer->company_name }}</div>
                                            <div class="text-xs text-gray-500">Servicer</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        @if($appointment->car->images->count() > 0)
                                            <img src="{{ Storage::url($appointment->car->images->first()->image_path) }}" alt="Car" class="w-10 h-10 rounded object-cover border">
                                        @else
                                            <span class="w-10 h-10 rounded bg-gray-100 flex items-center justify-center text-gray-400">🚗</span>
                                        @endif
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $appointment->car->make }} {{ $appointment->car->model }}</div>
                                            <div class="text-xs text-gray-500">Car</div>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap gap-2 text-sm">
                                        <span class="inline-block px-2 py-0.5 rounded bg-blue-100 text-blue-700 font-semibold">{{ $appointment->appointment_date->format('M d, Y') }}</span>
                                        <span class="inline-block px-2 py-0.5 rounded bg-gray-100 text-gray-700 font-semibold">{{ $appointment->start_time }}</span>
                                        <span class="inline-block px-2 py-0.5 rounded bg-green-100 text-green-700 font-semibold">{{ ucfirst($appointment->status) }}</span>
                                    </div>
                                    <div class="flex gap-2 mt-2">
                                        <a href="{{ route('appointments.show', $appointment) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs rounded-lg font-semibold shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                            View
                                        </a>
                                        @if($appointment->status === 'pending')
                                            <form action="{{ route('appointments.cancel', $appointment) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-xs rounded-lg font-semibold shadow hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 transition" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Add fade-in animation to table/cards
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