<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Car Details') }}
            </h2>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Dashboard
                </a>
                <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="text-red-600 hover:text-red-900 flex items-center gap-2 transition-colors duration-200"
                            onclick="return confirm('Are you sure you want to delete this car?')">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
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
                            <div class="relative max-w-2xl mx-auto">
                                <!-- Main Image -->
                                <div class="relative mx-auto" style="height: 350px; width: 100%; max-width: 600px;">
                                    <div class="bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden" style="height: 100%; width: 100%; position: relative;">
                                        @foreach($car->images as $index => $image)
                                            <img id="slide-{{ $index }}" src="{{ Storage::url($image->image_path) }}" alt="Car image" class="max-h-full max-w-full object-contain transition-opacity duration-300 ease-in-out mx-auto my-auto" style="opacity: {{ $index === 0 ? '1' : '0' }}; display: {{ $index === 0 ? 'block' : 'none' }}; z-index: 1;">
                                        @endforeach
                                        @if($car->images->count() > 1)
                                            <button onclick="prevImage()" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-70 text-white p-3 rounded-full hover:bg-opacity-90 z-30 shadow-lg border-2 border-white" style="font-size: 2rem;">
                                                &#8592;
                                            </button>
                                            <button onclick="nextImage()" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-70 text-white p-3 rounded-full hover:bg-opacity-90 z-30 shadow-lg border-2 border-white" style="font-size: 2rem;">
                                                &#8594;
                                            </button>
                                        @endif
                                        <div id="slide-indicator" class="absolute bottom-2 left-1/2 transform -translate-x-1/2 bg-black bg-opacity-60 text-white text-xs px-3 py-1 rounded-full z-30">
                                            Image 1 of {{ $car->images->count() }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Thumbnails -->
                                @if($car->images->count() > 1)
                                    <div class="flex justify-center space-x-2 mt-4 thumbnail-nav">
                                        @foreach($car->images as $index => $image)
                                            <button onclick="goToSlide({{ $index }})" class="w-16 h-16 rounded-lg overflow-hidden focus:outline-none focus:ring-2 focus:ring-blue-500 transition-opacity hover:opacity-75 {{ $index === 0 ? 'ring-2 ring-blue-500' : '' }}">
                                                <img src="{{ Storage::url($image->image_path) }}" alt="Thumbnail" class="w-full h-full object-cover">
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Car Information -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Main Info -->
                        <div class="lg:col-span-2">
                            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                                <h3 class="text-2xl font-bold mb-4">{{ $car->make }} {{ $car->model }}</h3>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-600">Year</p>
                                        <p class="font-semibold">{{ $car->year }}</p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-600">Price</p>
                                        <p class="font-semibold text-blue-600">€{{ number_format($car->price, 2) }}</p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-600">Location</p>
                                        <p class="font-semibold">{{ $car->location }}</p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-600">Power</p>
                                        <p class="font-semibold">{{ $car->power }} HP</p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-600">Mileage</p>
                                        <p class="font-semibold">{{ number_format($car->mileage) }} km</p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-600">Gearbox</p>
                                        <p class="font-semibold">{{ $car->gearbox }}</p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-600">Fuel Type</p>
                                        <p class="font-semibold">{{ $car->fuel }}</p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-600">Engine Size</p>
                                        <p class="font-semibold">{{ $car->engine_size }}L</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                                <h3 class="text-xl font-semibold mb-4">Description</h3>
                                <div class="prose max-w-none">
                                    <p class="text-gray-700 whitespace-pre-line">{{ $car->description }}</p>
                                </div>
                            </div>

                            <!-- Equipment -->
                            <div class="bg-white rounded-xl shadow-sm p-6">
                                <h3 class="text-xl font-semibold mb-4">Equipment</h3>
                                @if($car->equipment)
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($car->equipment as $item)
                                            <div class="flex items-center bg-gray-50 p-3 rounded-lg">
                                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                <span class="text-gray-700">{{ $item }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500">No equipment listed</p>
                                @endif
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="lg:col-span-1">
                            <!-- Seller Information -->
                            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                                <h3 class="text-xl font-semibold mb-4">Seller Information</h3>
                                <div class="space-y-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span class="text-blue-600 font-semibold">{{ substr($car->user->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold">{{ $car->user->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $car->user->email }}</p>
                                            <p class="text-sm text-gray-600">{{ $car->user->role->name ?? 'No Role' }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('admin.users.show', $car->user) }}" 
                                           class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-black rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            View Seller Profile
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Admin Actions -->
                            <div class="bg-white rounded-xl shadow-sm p-6">
                                <h3 class="text-xl font-semibold mb-4">Admin Actions</h3>
                                <div class="space-y-3">
                                    <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="w-full">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200"
                                                onclick="return confirm('Are you sure you want to delete this car?')">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete Car
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($car->images->isNotEmpty())
        <script>
            let currentSlide = 0;
            const totalSlides = {{ $car->images->count() }};

            function showSlide(index) {
                for (let i = 0; i < totalSlides; i++) {
                    const img = document.getElementById(`slide-${i}`);
                    img.style.opacity = '0';
                    img.style.display = 'none';
                }
                const currentImg = document.getElementById(`slide-${index}`);
                currentImg.style.opacity = '1';
                currentImg.style.display = 'block';
                document.querySelectorAll('.thumbnail-nav button').forEach((thumb, i) => {
                    if (i === index) {
                        thumb.classList.add('ring-2', 'ring-blue-500');
                    } else {
                        thumb.classList.remove('ring-2', 'ring-blue-500');
                    }
                });
                // Update slide indicator
                const indicator = document.getElementById('slide-indicator');
                if (indicator) {
                    indicator.textContent = `Image ${index + 1} of ${totalSlides}`;
                }
            }

            function nextImage() {
                currentSlide = (currentSlide + 1) % totalSlides;
                showSlide(currentSlide);
            }

            function prevImage() {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                showSlide(currentSlide);
            }

            function goToSlide(index) {
                currentSlide = index;
                showSlide(currentSlide);
            }

            document.addEventListener('DOMContentLoaded', function() {
                showSlide(0);
            });
        </script>
    @endif
</x-app-layout> 