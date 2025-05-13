<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Appointment Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Appointment Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Status</p>
                                <p class="font-medium">{{ ucfirst($appointment->status) }}</p>
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

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Car Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Make</p>
                                <p class="font-medium">{{ $appointment->car->make }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Model</p>
                                <p class="font-medium">{{ $appointment->car->model }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Year</p>
                                <p class="font-medium">{{ $appointment->car->year }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">License Plate</p>
                                <p class="font-medium">{{ $appointment->car->license_plate }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Servicer Information</h3>
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
                                <p class="font-medium">{{ $appointment->servicer->phone }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Address</p>
                                <p class="font-medium">{{ $appointment->servicer->address }}</p>
                            </div>
                        </div>
                    </div>

                    @if($appointment->status === 'pending')
                    <div class="mt-6">
                        <form action="{{ route('appointments.cancel', $appointment) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-black font-bold py-2 px-4 rounded">
                                Cancel Appointment
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 