<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Dashboard') }}
            </h2>
            <a href="{{ route('welcome') }}" class="text-blue-500 hover:text-blue-700">
                Welcome Page
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-6">Welcome, {{ auth()->user()->name }}! This is your user dashboard.</p>

                    <!-- Cars Management Section -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">My Cars</h3>
                        <div class="flex space-x-4 mb-6">
                            <a href="{{ route('user.cars.index') }}" class="bg-blue-500 hover:bg-blue-700 text-gray-800 font-bold py-2 px-4 rounded">
                                View My Cars
                            </a>
                            <a href="{{ route('user.cars.create') }}" class="bg-green-500 hover:bg-green-700 text-gray-800 font-bold py-2 px-4 rounded">
                                Add New Car
                            </a>
                        </div>
                    </div>

                    <!-- Watchlist Section -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">My Watchlist</h3>
                        <div class="flex space-x-4">
                            <a href="{{ route('favorites.index') }}" class="bg-yellow-500 hover:bg-yellow-700 text-gray-800 font-bold py-2 px-4 rounded">
                                View Watchlist
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 