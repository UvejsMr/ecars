<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Watchlist') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($favorites->isEmpty())
                        <p class="text-gray-500">Your watchlist is empty. Browse cars and add them to your watchlist!</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($favorites as $favorite)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                    @if($favorite->car->images->isNotEmpty())
                                        <div class="relative max-w-xl mx-auto">
                                            <img src="{{ asset('storage/' . $favorite->car->images->first()->image_path) }}" 
                                                 alt="{{ $favorite->car->make }} {{ $favorite->car->model }}" 
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
                                        <h3 class="text-lg font-semibold mb-2">
                                            {{ $favorite->car->year }} {{ $favorite->car->make }} {{ $favorite->car->model }}
                                        </h3>
                                        <p class="text-gray-600 mb-2">Price: €{{ number_format($favorite->car->price, 2) }}</p>
                                        <p class="text-gray-600 mb-4">Mileage: {{ number_format($favorite->car->mileage) }} km</p>
                                        <div class="flex justify-between items-center">
                                            <a href="{{ route('cars.show', $favorite->car) }}" 
                                               class="text-blue-500 hover:text-blue-700">
                                                View Details
                                            </a>
                                            <form action="{{ route('favorites.toggle', $favorite->car) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-red-500 hover:text-red-700">
                                                    Remove from Watchlist
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