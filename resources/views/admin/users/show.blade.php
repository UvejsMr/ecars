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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">User Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Name</p>
                            <p class="font-medium">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-medium">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Role</p>
                            <p class="font-medium">{{ $user->role->name ?? 'No Role' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Registered On</p>
                            <p class="font-medium">{{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User's Cars -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Posted Cars</h3>
                    @if($user->cars->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($user->cars as $car)
                                <div class="border rounded-lg overflow-hidden">
                                    @if($car->images->count() > 0)
                                        <div class="relative max-w-xl mx-auto">
                                            <div class="relative">
                                                <img src="{{ Storage::url($car->images->first()->image_path) }}" 
                                                     alt="{{ $car->full_name }}" 
                                                     class="w-full h-24 object-contain rounded-lg shadow-sm">
                                            </div>
                                        </div>
                                    @else
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500">No Image</span>
                                        </div>
                                    @endif
                                    <div class="p-4">
                                        <h4 class="font-semibold text-lg mb-2">{{ $car->full_name }}</h4>
                                        <p class="text-gray-600 mb-2">Price: €{{ number_format($car->price, 2) }}</p>
                                        <p class="text-gray-600 mb-2">Mileage: {{ number_format($car->mileage) }} km</p>
                                        <p class="text-gray-600 mb-2">Location: {{ $car->location }}</p>
                                        <div class="mt-4">
                                            <a href="{{ route('admin.cars.show', $car) }}" 
                                               class="text-indigo-600 hover:text-indigo-900 mr-2">View Details</a>
                                            <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Are you sure you want to delete this car?')">
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
        </div>
    </div>
</x-app-layout> 