<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Car Details') }}
            </h2>
            <a href="{{ url()->previous() }}" class="text-gray-600 hover:text-gray-900">Back</a>
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
                        </div>
                    </div>

                    <!-- Add this after the seller information section -->
                    @if(auth()->check() && auth()->id() !== $car->user_id)
                        <div class="mt-6">
                            <a href="{{ route('chat.start', $car->id) }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Chat with Seller
                            </a>
                        </div>
                    @endif
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
                    indicator.textContent = `Slide ${index + 1} of ${totalSlides}`;
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