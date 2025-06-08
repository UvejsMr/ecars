<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Details') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- User Information -->
            <div class="bg-white rounded-2xl shadow-lg mb-8 p-6">
                <h3 class="text-xl font-bold mb-6 text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    User Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <div>
                        <p class="text-sm text-gray-600">Name</p>
                        <p class="font-medium text-lg text-gray-900">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-medium text-lg text-gray-900">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Role</p>
                        @php
                            $role = \App\Models\Role::find($user->role_id);
                            $roleName = $role ? $role->name : 'No Role';
                            $roleColor = match($roleName) {
                                'Admin' => 'bg-red-100 text-red-700',
                                'User' => 'bg-green-100 text-green-700',
                                'Servicer' => 'bg-yellow-100 text-yellow-700',
                                default => 'bg-gray-200 text-gray-600',
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $roleColor }}">
                            {{ $roleName }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Registered On</p>
                        <p class="font-medium text-lg text-gray-900">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- User's Cars -->
            @if($roleName === 'User')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                        </svg>
                        Posted Cars
                    </h3>
                    @if($user->cars->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($user->cars as $car)
                                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-shadow duration-200 border flex flex-col overflow-hidden group">
                                    <div class="relative w-full aspect-w-16 aspect-h-9 bg-gray-100 flex items-center justify-center">
                                        @if($car->images->count() > 0)
                                            <img src="{{ Storage::url($car->images->first()->image_path) }}"
                                                 alt="{{ $car->full_name }}"
                                                 class="w-full h-full object-cover rounded-t-2xl transition-transform duration-200 group-hover:scale-105">
                                        @else
                                            <span class="text-gray-400">No Image</span>
                                        @endif
                                    </div>
                                    <div class="p-5 flex-1 flex flex-col justify-between">
                                        <div>
                                            <h4 class="font-bold text-lg mb-2 text-gray-900 truncate">{{ $car->full_name }}</h4>
                                            <div class="flex flex-wrap gap-2 mb-3">
                                                <span class="inline-block px-2 py-0.5 rounded bg-blue-100 text-blue-700 text-xs font-semibold">{{ $car->year }}</span>
                                                <span class="inline-block px-2 py-0.5 rounded bg-gray-200 text-gray-700 text-xs font-semibold">{{ number_format($car->mileage) }} km</span>
                                                <span class="inline-block px-2 py-0.5 rounded bg-yellow-100 text-yellow-700 text-xs font-semibold">{{ $car->fuel }}</span>
                                                <span class="inline-block px-2 py-0.5 rounded bg-purple-100 text-purple-700 text-xs font-semibold">{{ $car->gearbox }}</span>
                                            </div>
                                            <div class="mb-2">
                                                <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 font-bold text-sm">€{{ number_format($car->price, 2) }}</span>
                                            </div>
                                            <div class="mb-2 text-gray-600 text-sm">
                                                <span class="font-medium">Location:</span> {{ $car->location }}
                                            </div>
                                        </div>
                                        <div class="mt-4 flex gap-2">
                                            <a href="{{ route('admin.cars.show', $car) }}"
                                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs rounded-lg font-semibold shadow hover:bg-blue-700 transition">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                                View Details
                                            </a>
                                            <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-xs rounded-lg font-semibold shadow hover:bg-red-700 transition"
                                                        onclick="return confirm('Are you sure you want to delete this car?')">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">This user hasn't posted any cars yet.</p>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout> 