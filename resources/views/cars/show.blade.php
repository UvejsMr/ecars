<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Car Details') }}
            </h2>
            <a href="{{ url()->previous() }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
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
                                            Slide 1 of {{ $car->images->count() }}
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
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            @if(auth()->check() && auth()->id() !== $car->user_id)
                                <div class="flex flex-col gap-3">
                                    <div class="flex gap-3">
                                        <a href="{{ route('chat.start', $car->id) }}" 
                                           class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-black text-black rounded-lg hover:bg-gray-800 hover:text-white transition-colors duration-200">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                            Chat with Seller
                                        </a>
                                        @if(!auth()->user()->isServicer())
                                            <a href="{{ route('appointments.select-servicer', $car) }}" 
                                               class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-black text-black rounded-lg hover:bg-gray-800 hover:text-white transition-colors duration-200">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                Book Inspection
                                            </a>
                                        @endif
                                    </div>
                                    <form action="{{ route('favorites.toggle', $car) }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full inline-flex items-center justify-center px-4 py-3 bg-black text-black rounded-lg hover:bg-gray-800 hover:text-white transition-colors duration-200">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                            {{ $car->isFavoritedBy(auth()->user()) ? 'Remove from Watchlist' : 'Add to Watchlist' }}
                                        </button>
                                    </form>
                                </div>
                            @endif
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