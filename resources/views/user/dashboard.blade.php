<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="/" class="text-blue-500 underline mb-4 inline-block">Go to Welcome Page</a>
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 