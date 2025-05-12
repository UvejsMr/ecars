<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Info') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="/" class="text-blue-500 underline mb-4 inline-block">Go to Welcome Page</a>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-500 underline mb-4 inline-block ml-4">Back to Admin Dashboard</a>
                    <h3 class="text-lg font-semibold mb-4">User Details</h3>
                    <ul>
                        <li><strong>Name:</strong> {{ $user->name }}</li>
                        <li><strong>Email:</strong> {{ $user->email }}</li>
                        <li><strong>Role:</strong> {{ $user->role->name }}</li>
                        <li><strong>Created At:</strong> {{ $user->created_at }}</li>
                        <li><strong>Updated At:</strong> {{ $user->updated_at }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 