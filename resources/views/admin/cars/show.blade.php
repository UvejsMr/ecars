<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Car Details') }}
            </h2>
            <div class="flex space-x-8">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900">Back to Dashboard</a>
                <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="text-red-600 hover:text-red-900"
                            onclick="return confirm('Are you sure you want to delete this car?')">
                        Delete Car
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Car Images -->
                    @if($car->images->isNotEmpty())
                        <div class="mb-8">
                            <div class="relative max-w-xl mx-auto">
                                <!-- Main Image -->
                                <div class="relative">
                                    <img id="mainImage" 
                                         src="{{ Storage::url($car->images->first()->image_path) }}" 
                                         alt="Car image" 
                                         class="w-full h-24 object-contain rounded-lg shadow-sm">
                                    
                                    <!-- Navigation Arrows -->
                                    @if($car->images->count() > 1)
                                        <button onclick="prevImage()" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                            </svg>
                                        </button>
                                        <button onclick="nextImage()" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>

                                <!-- Thumbnails -->
                                @if($car->images->count() > 1)
                                    <div class="flex justify-center space-x-2 mt-4">
                                        @foreach($car->images as $index => $image)
                                            <button onclick="showImage({{ $index }})" 
                                                    class="w-16 h-16 rounded-lg overflow-hidden focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <img src="{{ Storage::url($image->image_path) }}" 
                                                     alt="Thumbnail" 
                                                     class="w-full h-full object-cover">
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Car Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Car Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm mb-2"><span class="font-medium">Make:</span> {{ $car->make }}</p>
                                <p class="text-sm mb-2"><span class="font-medium">Model:</span> {{ $car->model }}</p>
                                <p class="text-sm mb-2"><span class="font-medium">Year:</span> {{ $car->year }}</p>
                                <p class="text-sm mb-2"><span class="font-medium">Price:</span> €{{ number_format($car->price, 2) }}</p>
                                <p class="text-sm mb-2"><span class="font-medium">Location:</span> {{ $car->location }}</p>
                            </div>
                            <div>
                                <p class="text-sm mb-2"><span class="font-medium">Power:</span> {{ $car->power }} HP</p>
                                <p class="text-sm mb-2"><span class="font-medium">Mileage:</span> {{ number_format($car->mileage) }} km</p>
                                <p class="text-sm mb-2"><span class="font-medium">Gearbox:</span> {{ $car->gearbox }}</p>
                                <p class="text-sm mb-2"><span class="font-medium">Fuel Type:</span> {{ $car->fuel }}</p>
                                <p class="text-sm mb-2"><span class="font-medium">Engine Size:</span> {{ $car->engine_size }}L</p>
                            </div>
                        </div>
                    </div>

                    <!-- Equipment -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Equipment</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            @if($car->equipment)
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach($car->equipment as $item)
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="text-sm">{{ $item }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500">No equipment listed</p>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Description</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm whitespace-pre-line">{{ $car->description }}</p>
                        </div>
                    </div>

                    <!-- Seller Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Seller Information</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm"><span class="font-medium">Name:</span> {{ $car->user->name }}</p>
                            <p class="text-sm"><span class="font-medium">Email:</span> {{ $car->user->email }}</p>
                            <p class="text-sm"><span class="font-medium">Role:</span> {{ $car->user->role->name ?? 'No Role' }}</p>
                            <div class="mt-4">
                                <a href="{{ route('admin.users.show', $car->user) }}" 
                                   class="text-indigo-600 hover:text-indigo-900">
                                    View Seller Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($car->images->isNotEmpty())
        <script>
            const images = @json($car->images->pluck('image_path'));
            let currentImageIndex = 0;

            function showImage(index) {
                currentImageIndex = index;
                updateMainImage();
            }

            function nextImage() {
                currentImageIndex = (currentImageIndex + 1) % images.length;
                updateMainImage();
            }

            function prevImage() {
                currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
                updateMainImage();
            }

            function updateMainImage() {
                const mainImage = document.getElementById('mainImage');
                mainImage.src = `/storage/${images[currentImageIndex]}`;
            }
        </script>
    @endif
</x-app-layout> 