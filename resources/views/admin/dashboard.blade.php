<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
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
                    <!-- Users Section -->
                    <h3 class="text-lg font-semibold mb-4">All Users</h3>
                    <div class="overflow-x-auto mb-8">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $role = \App\Models\Role::find($user->role_id);
                                            @endphp
                                            {{ $role ? $role->name : 'No Role' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('admin.users.show', $user) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">View</a>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this user?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Cars Section -->
                    <h3 class="text-lg font-semibold mb-4">All Cars</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posted By</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Car Details</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($cars as $car)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $car->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $car->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $car->full_name }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $car->year }} • {{ $car->mileage }} km • {{ $car->fuel }} • {{ $car->gearbox }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">€{{ number_format($car->price, 2) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $car->location }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('admin.cars.show', $car) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">View</a>
                                            <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this car?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Unverified Servicers</h3>
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                @forelse($unverifiedServicers as $servicer)
                                    <div class="border-b last:border-b-0 py-4">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <h4 class="font-medium">{{ $servicer->company_name }}</h4>
                                                <p class="text-sm text-gray-600">{{ $servicer->user->email }}</p>
                                                <p class="text-sm text-gray-600">{{ $servicer->phone_number }}</p>
                                            </div>
                                            <form action="{{ route('admin.servicers.verify', $servicer) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="px-4 py-2 bg-green-500 text-black rounded-md hover:bg-green-600">
                                                    Verify Servicer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500">No unverified servicers.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 