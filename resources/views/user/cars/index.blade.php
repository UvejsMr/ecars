<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Cars') }}
            </h2>
            <a href="{{ route('user.cars.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Add New Car
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($cars->isEmpty())
                        <p class="text-gray-500 text-center py-4">You haven't added any cars yet.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($cars as $car)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                    @if($car->images->isNotEmpty())
                                        <div class="relative max-w-xl mx-auto">
                                            <img src="{{ Storage::url($car->images->first()->image_path) }}" 
                                                 alt="{{ $car->full_name }}" 
                                                 class="w-full h-24 object-contain rounded-lg shadow-sm">
                                        </div>
                                    @else
                                        <div class="relative max-w-xl mx-auto">
                                            <div class="w-full h-24 bg-gray-200 flex items-center justify-center rounded-lg">
                                                <span class="text-gray-400">No image available</span>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold mb-2">{{ $car->full_name }}</h3>
                                        <p class="text-gray-600 mb-2">€{{ number_format($car->price, 2) }}</p>
                                        <div class="text-sm text-gray-500 mb-4">
                                            <p>{{ $car->mileage }} km • {{ $car->fuel }} • {{ $car->gearbox }}</p>
                                            <p>{{ $car->location }}</p>
                                        </div>
                                        
                                        <div class="flex justify-between items-center">
                                            <a href="{{ route('user.cars.edit', $car) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            
                                            <form action="{{ route('user.cars.destroy', $car) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this car?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    Delete
                                                </button>
                                            </form>
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