<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Servicer Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="/" class="text-blue-500 underline mb-4 inline-block">Go to Welcome Page</a>
                    <p>Welcome, {{ auth()->user()->name }}! This is your servicer dashboard.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 