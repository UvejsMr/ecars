<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Car Details') }}
            </h2>
            <a href="{{ route('welcome') }}" class="inline-flex items-center gap-2 px-5 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg shadow hover:bg-gray-300 transition">
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
                            <div class="relative max-w-2xl mx-auto group">
                                <!-- Main Image -->
                                <div class="relative mx-auto cursor-zoom-in" style="height: 350px; width: 100%; max-width: 600px;" onclick="openModal()">
                                    <div class="bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden" style="height: 100%; width: 100%; position: relative;">
                                        @foreach($car->images as $index => $image)
                                            <img id="slide-{{ $index }}" src="{{ Storage::url($image->image_path) }}" alt="Car image {{ $index+1 }}" class="main-carousel-img absolute inset-0 w-full h-full object-contain transition-opacity duration-500 ease-in-out mx-auto my-auto rounded-lg {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}" style="background: #f1f5f9;" />
                                        @endforeach
                                        @if($car->images->count() > 1)
                                            <button onclick="event.stopPropagation(); prevImage();" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-60 text-white p-4 rounded-full hover:bg-opacity-90 z-30 shadow-lg border-2 border-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500" style="font-size: 2rem;">
                                                &#8592;
                                            </button>
                                            <button onclick="event.stopPropagation(); nextImage();" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-60 text-white p-4 rounded-full hover:bg-opacity-90 z-30 shadow-lg border-2 border-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500" style="font-size: 2rem;">
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
                                            <button onclick="goToSlide({{ $index }});" class="w-16 h-16 rounded-lg overflow-hidden focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 hover:opacity-80 border-2 border-transparent {{ $index === 0 ? 'ring-2 ring-blue-500 border-blue-500' : '' }}">
                                                <img src="{{ Storage::url($image->image_path) }}" alt="Thumbnail {{ $index+1 }}" class="w-full h-full object-cover">
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!-- Modal/Lightbox for zoom -->
                        <div id="imageModal" class="fixed inset-0 z-50 bg-black bg-opacity-80 flex items-center justify-center hidden transition-all duration-300">
                            <button onclick="closeModal()" class="absolute top-6 right-8 text-white text-3xl font-bold hover:text-red-400 transition z-60">&times;</button>
                            <div class="relative w-full max-w-3xl flex flex-col items-center">
                                <img id="modalImage" src="" alt="Zoomed Car Image" class="w-full max-h-[80vh] object-contain rounded-xl shadow-2xl transition-all duration-300" />
                                <div class="flex justify-between w-full mt-4">
                                    <button onclick="modalPrevImage()" class="bg-black bg-opacity-60 text-white p-3 rounded-full hover:bg-opacity-90 shadow-lg border-2 border-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">&#8592;</button>
                                    <button onclick="modalNextImage()" class="bg-black bg-opacity-60 text-white p-3 rounded-full hover:bg-opacity-90 shadow-lg border-2 border-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">&#8594;</button>
                                </div>
                                <div id="modal-slide-indicator" class="mt-2 bg-black bg-opacity-60 text-white text-xs px-3 py-1 rounded-full">Image 1 of {{ $car->images->count() }}</div>
                            </div>
                        </div>
                        <script>
                            let currentSlide = 0;
                            const totalSlides = {{ $car->images->count() }};
                            let autoAdvanceInterval = null;
                            let isModalOpen = false;
                            const imageUrls = [
                                @foreach($car->images as $image)
                                    "{{ Storage::url($image->image_path) }}",
                                @endforeach
                            ];

                            function showSlide(index) {
                                for (let i = 0; i < totalSlides; i++) {
                                    const img = document.getElementById(`slide-${i}`);
                                    if (i === index) {
                                        img.classList.add('opacity-100', 'z-10');
                                        img.classList.remove('opacity-0', 'z-0');
                                    } else {
                                        img.classList.remove('opacity-100', 'z-10');
                                        img.classList.add('opacity-0', 'z-0');
                                    }
                                }
                                document.querySelectorAll('.thumbnail-nav button').forEach((thumb, i) => {
                                    if (i === index) {
                                        thumb.classList.add('ring-2', 'ring-blue-500', 'border-blue-500');
                                    } else {
                                        thumb.classList.remove('ring-2', 'ring-blue-500', 'border-blue-500');
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
                            // Auto-advance
                            function startAutoAdvance() {
                                if (autoAdvanceInterval) return;
                                autoAdvanceInterval = setInterval(() => {
                                    if (!isModalOpen) nextImage();
                                }, 3500);
                            }
                            function stopAutoAdvance() {
                                clearInterval(autoAdvanceInterval);
                                autoAdvanceInterval = null;
                            }
                            // Modal/Lightbox
                            function openModal() {
                                isModalOpen = true;
                                document.getElementById('imageModal').classList.remove('hidden');
                                setModalImage(currentSlide);
                            }
                            function closeModal() {
                                isModalOpen = false;
                                document.getElementById('imageModal').classList.add('hidden');
                            }
                            function setModalImage(index) {
                                const modalImg = document.getElementById('modalImage');
                                modalImg.src = imageUrls[index];
                                document.getElementById('modal-slide-indicator').textContent = `Image ${index + 1} of ${totalSlides}`;
                            }
                            function modalNextImage() {
                                currentSlide = (currentSlide + 1) % totalSlides;
                                setModalImage(currentSlide);
                                showSlide(currentSlide);
                            }
                            function modalPrevImage() {
                                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                                setModalImage(currentSlide);
                                showSlide(currentSlide);
                            }
                            // Pause auto-advance on hover
                            document.addEventListener('DOMContentLoaded', function() {
                                showSlide(0);
                                startAutoAdvance();
                                document.querySelector('.main-carousel-img').parentElement.addEventListener('mouseenter', stopAutoAdvance);
                                document.querySelector('.main-carousel-img').parentElement.addEventListener('mouseleave', startAutoAdvance);
                            });
                        </script>
                    @endif

                    <!-- Car Information -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Main Info -->
                        <div class="lg:col-span-2">
                            <div class="bg-white rounded-2xl shadow-lg p-8 mb-6 border border-gray-100">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                                    <h3 class="text-2xl font-bold text-gray-900 flex items-center gap-3 mb-2 md:mb-0">
                                        <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13l2-2m0 0l7-7 7 7M5 11v8a2 2 0 002 2h10a2 2 0 002-2v-8" /></svg>
                                        {{ $car->make }} {{ $car->model }}
                                    </h3>
                                    <span class="inline-block px-5 py-2 rounded-full bg-green-100 text-green-700 text-xl font-bold shadow-sm border border-green-200">
                                        €{{ number_format($car->price, 2) }}
                                    </span>
                                </div>
                                <div class="flex flex-wrap gap-3 mb-6">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" /></svg>
                                        {{ $car->year }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-gray-200 text-gray-700 text-sm font-semibold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1" /></svg>
                                        {{ number_format($car->mileage) }} km
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm font-semibold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                        {{ $car->fuel }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-purple-100 text-purple-700 text-sm font-semibold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17l4 4 4-4m0 0V3m0 18H4" /></svg>
                                        {{ $car->gearbox }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-pink-100 text-pink-700 text-sm font-semibold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6" /></svg>
                                        {{ $car->engine_size }}L
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-sm font-semibold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2h5" /></svg>
                                        {{ $car->power }} HP
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-sm font-semibold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2h5" /></svg>
                                        {{ $car->location }}
                                    </span>
                                </div>
                                <div class="border-t pt-6 mt-6">
                                    <h4 class="text-lg font-semibold mb-2 text-gray-800 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                        Description
                                    </h4>
                                    <div class="prose max-w-none">
                                        <p class="text-gray-700 whitespace-pre-line">{{ $car->description }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Equipment -->
                            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                                <h3 class="text-xl font-semibold mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Equipment
                                </h3>
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
                            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8 border border-gray-100">
                                <h3 class="text-xl font-semibold mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    Seller Information
                                </h3>
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center text-3xl font-bold text-blue-600 shadow">
                                        {{ substr($car->user->name, 0, 1) }}
                                    </div>
                                    <div class="text-center">
                                        <p class="font-semibold text-lg text-gray-900">{{ $car->user->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $car->user->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            @if(auth()->check() && auth()->id() !== $car->user_id && !auth()->user()->isServicer() && !auth()->user()->isAdmin())
                                <div class="flex flex-col gap-3">
                                    <div class="flex gap-3">
                                        <a href="{{ route('chat.start', $car->id) }}"
                                           class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-lg font-semibold shadow hover:bg-blue-700 transition">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                            Chat with Seller
                                        </a>
                                        
                                        <a href="{{ route('appointments.select-servicer', $car) }}"
                                           class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-green-600 text-white rounded-lg font-semibold shadow hover:bg-green-700 transition">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Book Inspection
                                        </a>
                                    </div>
                                    <form action="{{ route('favorites.toggle', $car) }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit"
                                                class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-100 text-red-700 rounded-lg font-semibold shadow hover:bg-red-200 transition">
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
</x-app-layout>