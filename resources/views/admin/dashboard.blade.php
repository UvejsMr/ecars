<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Overview -->
            <div class="w-full mb-8">
                <div class="bg-white rounded-2xl shadow-lg p-8 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="flex-1 flex flex-col items-center justify-center">
                        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-blue-600 mb-2">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div class="text-lg font-semibold text-gray-700">Total Users</div>
                        <div class="text-3xl font-bold mt-1 text-gray-900">{{ $totalUsers }}</div>
                    </div>
                    <div class="flex-1 flex flex-col items-center justify-center">
                        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-green-600 mb-2">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                            </svg>
                        </div>
                        <div class="text-lg font-semibold text-gray-700">Total Cars</div>
                        <div class="text-3xl font-bold mt-1 text-gray-900">{{ $totalCars }}</div>
                    </div>
                    <div class="flex-1 flex flex-col items-center justify-center">
                        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-yellow-400 mb-2">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div class="text-lg font-semibold text-gray-700">Unverified Servicers</div>
                        <div class="text-3xl font-bold mt-1 text-gray-900">{{ $unverifiedServicers->count() }}</div>
                    </div>
                    <div class="flex-1 flex flex-col items-center justify-center">
                        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-purple-600 mb-2">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-lg font-semibold text-gray-700">Verified Servicers</div>
                        <div class="text-3xl font-bold mt-1 text-gray-900">{{ \App\Models\Servicer::where('is_verified', true)->count() }}</div>
                    </div>
                </div>
            </div>

            <!-- Users Section -->
            <div class="bg-white rounded-2xl shadow-lg mb-8 p-6">
                <h3 class="text-xl font-bold mb-6 text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    All Users
                </h3>
                <form method="GET" class="mb-4 flex items-center gap-2">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search users by name or email..." class="w-full md:w-1/3 rounded-lg border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition placeholder-gray-400" />
                    <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" /></svg>
                        Search
                    </button>
                </form>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-50 sticky top-0 z-10">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr class="hover:bg-blue-50 transition-colors duration-150 even:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $role = \App\Models\Role::find($user->role_id);
                                            $roleColor = match(optional($role)->name) {
                                                'Admin' => 'bg-red-100 text-red-700',
                                                'User' => 'bg-green-100 text-green-700',
                                                'Servicer' => 'bg-yellow-100 text-yellow-700',
                                                default => 'bg-blue-100 text-blue-700',
                                            };
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $roleColor }}">
                                            {{ $role ? $role->name : 'No Role' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                        <a href="{{ route('admin.users.show', $user) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                            View
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition" onclick="return confirm('Are you sure you want to delete this user?')">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Cars Section -->
            <div class="bg-white rounded-2xl shadow-lg mb-8 p-6">
                <h3 class="text-xl font-bold mb-6 text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                    </svg>
                    All Cars
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-green-50 sticky top-0 z-10">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Posted By</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Car Details</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Location</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-green-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($cars as $car)
                                <tr class="hover:bg-green-50 transition-colors duration-150 even:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $car->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $car->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $car->full_name }}</div>
                                        <div class="text-xs text-gray-500 flex flex-wrap gap-2 mt-1">
                                            <span class="inline-block px-2 py-0.5 rounded bg-blue-100 text-blue-700 font-semibold">{{ $car->year }}</span>
                                            <span class="inline-block px-2 py-0.5 rounded bg-gray-200 text-gray-700">{{ number_format($car->mileage) }} km</span>
                                            <span class="inline-block px-2 py-0.5 rounded bg-yellow-100 text-yellow-700">{{ $car->fuel }}</span>
                                            <span class="inline-block px-2 py-0.5 rounded bg-purple-100 text-purple-700">{{ $car->gearbox }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-green-700">€{{ number_format($car->price, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $car->location }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                        <a href="{{ route('admin.cars.show', $car) }}" class="inline-flex items-center px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                            View
                                        </a>
                                        <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition" onclick="return confirm('Are you sure you want to delete this car?')">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6 flex flex-col items-center justify-center">
                    {{ $cars->links() }}
                </div>
            </div>

            <!-- Unverified Servicers Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transform transition-all duration-300 hover:shadow-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Unverified Servicers
                    </h3>
                    <div class="space-y-4">
                        @forelse($unverifiedServicers as $servicer)
                            <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $servicer->company_name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $servicer->user->email }}</p>
                                        <p class="text-sm text-gray-600">{{ $servicer->phone_number }}</p>
                                    </div>
                                    <form action="{{ route('admin.servicers.verify', $servicer) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors duration-200 transform hover:scale-105">
                                            Verify Servicer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No unverified servicers.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Add fade-in animation to cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.bg-white');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease-out';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
    @endpush
</x-app-layout> 