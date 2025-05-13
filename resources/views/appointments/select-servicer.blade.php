<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Select a Servicer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Book Inspection for {{ $car->make }} {{ $car->model }}</h3>
                        <p class="text-gray-600">Select a verified servicer to inspect your car</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($servicers as $servicer)
                            <div class="border rounded-lg p-6 hover:shadow-lg transition">
                                <h4 class="text-lg font-semibold mb-2">{{ $servicer->company_name }}</h4>
                                <div class="space-y-2 text-sm text-gray-600">
                                    <p><span class="font-medium">Phone:</span> {{ $servicer->phone_number }}</p>
                                    <p><span class="font-medium">Address:</span> {{ $servicer->address }}</p>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('appointments.create', ['userId' => $servicer->user_id, 'carId' => $car->id]) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-500 text-black rounded-md hover:bg-blue-600 transition">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Book with this servicer
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <p class="text-gray-500">No verified servicers available at the moment.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 