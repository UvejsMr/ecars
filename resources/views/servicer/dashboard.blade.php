<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Servicer Dashboard') }}
            </h2>
            <a href="{{ route('servicer.edit') }}" class="text-blue-500 hover:text-blue-700">
                Edit Profile
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Your Appointments</h3>
                    
                    @if($appointments->isEmpty())
                        <p class="text-gray-500">No appointments yet.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($appointments as $appointment)
                                <div class="border rounded-lg p-4 {{ $appointment->status === 'pending' ? 'bg-yellow-50' : ($appointment->status === 'confirmed' ? 'bg-green-50' : ($appointment->status === 'completed' ? 'bg-blue-50' : 'bg-red-50')) }}">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-semibold">{{ $appointment->car->make }} {{ $appointment->car->model }}</h4>
                                            <p class="text-sm text-gray-600">Client: {{ $appointment->user->name }}</p>
                                            <p class="text-sm text-gray-600">
                                                Date: {{ $appointment->appointment_date->format('M d, Y') }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                Time: {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} - 
                                                {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}
                                            </p>
                                            @if($appointment->notes)
                                                <p class="text-sm text-gray-600 mt-2">
                                                    Notes: {{ $appointment->notes }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                                {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($appointment->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                                   ($appointment->status === 'completed' ? 'bg-blue-100 text-blue-800' : 
                                                   'bg-red-100 text-red-800')) }}">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                            @if($appointment->status === 'pending')
                                                <form action="{{ route('servicer.appointments.status', $appointment->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="text-green-600 hover:text-green-800">
                                                        Confirm
                                                    </button>
                                                </form>
                                            @endif
                                            @if($appointment->status === 'confirmed')
                                                <form action="{{ route('servicer.appointments.status', $appointment->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="text-blue-600 hover:text-blue-800">
                                                        Mark as Completed
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 