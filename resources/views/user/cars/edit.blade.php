<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Car') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('user.cars.update', $car) }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="updateCarForm">
                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Make -->
                            <div>
                                <x-input-label for="make" :value="__('Make')" />
                                <x-text-input id="make" name="make" type="text" class="mt-1 block w-full" :value="old('make', $car->make)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('make')" />
                            </div>

                            <!-- Model -->
                            <div>
                                <x-input-label for="model" :value="__('Model')" />
                                <x-text-input id="model" name="model" type="text" class="mt-1 block w-full" :value="old('model', $car->model)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('model')" />
                            </div>

                            <!-- Year -->
                            <div>
                                <x-input-label for="year" :value="__('Year')" />
                                <x-text-input id="year" name="year" type="number" class="mt-1 block w-full" :value="old('year', $car->year)" required min="1900" max="{{ date('Y') + 1 }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('year')" />
                            </div>

                            <!-- Power -->
                            <div>
                                <x-input-label for="power" :value="__('Power (HP)')" />
                                <x-text-input id="power" name="power" type="number" class="mt-1 block w-full" :value="old('power', $car->power)" required min="1" />
                                <x-input-error class="mt-2" :messages="$errors->get('power')" />
                            </div>

                            <!-- Mileage -->
                            <div>
                                <x-input-label for="mileage" :value="__('Mileage (km)')" />
                                <x-text-input id="mileage" name="mileage" type="number" class="mt-1 block w-full" :value="old('mileage', $car->mileage)" required min="0" />
                                <x-input-error class="mt-2" :messages="$errors->get('mileage')" />
                            </div>

                            <!-- Gearbox -->
                            <div>
                                <x-input-label for="gearbox" :value="__('Gearbox')" />
                                <select id="gearbox" name="gearbox" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select gearbox type</option>
                                    <option value="Manual" {{ old('gearbox', $car->gearbox) == 'Manual' ? 'selected' : '' }}>Manual</option>
                                    <option value="Automatic" {{ old('gearbox', $car->gearbox) == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                                    <option value="Semi-automatic" {{ old('gearbox', $car->gearbox) == 'Semi-automatic' ? 'selected' : '' }}>Semi-automatic</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('gearbox')" />
                            </div>

                            <!-- Fuel -->
                            <div>
                                <x-input-label for="fuel" :value="__('Fuel Type')" />
                                <select id="fuel" name="fuel" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select fuel type</option>
                                    <option value="Petrol" {{ old('fuel', $car->fuel) == 'Petrol' ? 'selected' : '' }}>Petrol</option>
                                    <option value="Diesel" {{ old('fuel', $car->fuel) == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                                    <option value="Electric" {{ old('fuel', $car->fuel) == 'Electric' ? 'selected' : '' }}>Electric</option>
                                    <option value="Hybrid" {{ old('fuel', $car->fuel) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('fuel')" />
                            </div>

                            <!-- Engine Size -->
                            <div>
                                <x-input-label for="engine_size" :value="__('Engine Size (L)')" />
                                <x-text-input id="engine_size" name="engine_size" type="number" step="0.1" class="mt-1 block w-full" :value="old('engine_size', $car->engine_size)" required min="0.1" />
                                <x-input-error class="mt-2" :messages="$errors->get('engine_size')" />
                            </div>

                            <!-- Price -->
                            <div>
                                <x-input-label for="price" :value="__('Price (€)')" />
                                <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full" :value="old('price', $car->price)" required min="0" />
                                <x-input-error class="mt-2" :messages="$errors->get('price')" />
                            </div>

                            <!-- Location -->
                            <div>
                                <x-input-label for="location" :value="__('Location')" />
                                <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $car->location)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('location')" />
                            </div>
                        </div>

                        <!-- Equipment -->
                        <div>
                            <x-input-label :value="__('Equipment')" />
                            <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-4">
                                @php
                                    $equipmentOptions = [
                                        'Air Conditioning', 'Bluetooth', 'Cruise Control', 'Parking Sensors',
                                        'Backup Camera', 'Navigation', 'Leather Seats', 'Sunroof',
                                        'Heated Seats', 'Keyless Entry', 'Power Windows', 'ABS',
                                        'ESP', 'Airbags', 'Alarm System', 'Alloy Wheels'
                                    ];
                                @endphp
                                @foreach($equipmentOptions as $option)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="equipment[]" value="{{ $option }}" 
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                               {{ in_array($option, old('equipment', $car->equipment ?? [])) ? 'checked' : '' }}>
                                        <label class="ml-2 text-sm text-gray-600">{{ $option }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('equipment')" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('description', $car->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <!-- Current Images -->
                        @if($car->images->isNotEmpty())
                            <div class="flex flex-col items-center">
                                <x-input-label :value="__('Current Images')" />
                                <div class="mt-2 w-full max-w-xl">
                                    <!-- Main Carousel -->
                                    <div class="relative" style="height: 100px;">
                                        @foreach($car->images as $index => $image)
                                            <div id="edit-slide-{{ $index }}" class="absolute inset-0 flex items-center justify-center transition-opacity duration-300 ease-in-out" style="opacity: {{ $index === 0 ? '1' : '0' }}; display: {{ $index === 0 ? 'block' : 'none' }};">
                                                <img src="{{ Storage::url($image->image_path) }}" alt="Car image" class="max-h-full max-w-full object-contain bg-gray-100 rounded-lg">
                                                <!-- Delete Button for this image -->
                                                <form action="{{ route('user.cars.images.destroy', $image) }}" method="POST" class="absolute top-2 right-2" onsubmit="return confirm('Are you sure you want to delete this image?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 text-white p-1 rounded-full hover:bg-red-600">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @endforeach
                                        <!-- Navigation Buttons -->
                                        @if($car->images->count() > 1)
                                            <button type="button" onclick="editPrevSlide()" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-1 rounded-full hover:bg-opacity-75 z-10">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                                </svg>
                                            </button>
                                            <button type="button" onclick="editNextSlide()" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-1 rounded-full hover:bg-opacity-75 z-10">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                    <!-- Thumbnail Navigation -->
                                    <div class="mt-2 flex justify-center space-x-1 overflow-x-auto py-1 thumbnail-nav">
                                        @foreach($car->images as $index => $image)
                                            <div class="relative group">
                                                <img src="{{ Storage::url($image->image_path) }}" alt="Thumbnail" onclick="editGoToSlide({{ $index }})" class="w-12 h-12 object-cover rounded cursor-pointer hover:opacity-75 transition-opacity {{ $index === 0 ? 'ring-2 ring-blue-500' : '' }}" id="edit-thumb-{{ $index }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <script>
                                let editCurrentSlide = 0;
                                const editTotalSlides = {{ $car->images->count() }};
                                function editShowSlide(index) {
                                    for (let i = 0; i < editTotalSlides; i++) {
                                        const slide = document.getElementById(`edit-slide-${i}`);
                                        const thumb = document.getElementById(`edit-thumb-${i}`);
                                        if (slide) {
                                            slide.style.opacity = '0';
                                            slide.style.display = 'none';
                                        }
                                        if (thumb) {
                                            thumb.classList.remove('ring-2', 'ring-blue-500');
                                        }
                                    }
                                    const currentSlide = document.getElementById(`edit-slide-${index}`);
                                    const currentThumb = document.getElementById(`edit-thumb-${index}`);
                                    if (currentSlide) {
                                        currentSlide.style.opacity = '1';
                                        currentSlide.style.display = 'block';
                                    }
                                    if (currentThumb) {
                                        currentThumb.classList.add('ring-2', 'ring-blue-500');
                                    }
                                    editCurrentSlide = index;
                                }
                                function editNextSlide() {
                                    editCurrentSlide = (editCurrentSlide + 1) % editTotalSlides;
                                    editShowSlide(editCurrentSlide);
                                }
                                function editPrevSlide() {
                                    editCurrentSlide = (editCurrentSlide - 1 + editTotalSlides) % editTotalSlides;
                                    editShowSlide(editCurrentSlide);
                                }
                                function editGoToSlide(index) {
                                    editShowSlide(index);
                                }
                                document.addEventListener('DOMContentLoaded', function() {
                                    editShowSlide(0);
                                });
                            </script>
                        @endif

                        <!-- New Images -->
                        <div>
                            <x-input-label for="images" :value="__('Add New Images (optional)')" />
                            <input type="file" id="images" name="images[]" multiple accept="image/*" class="mt-1 block w-full">
                            <p class="mt-1 text-sm text-gray-500">You can select up to 10 images. Maximum size: 2MB per image.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('images')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Update Car') }}
                            </button>
                            <a href="{{ route('user.cars.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                        </div>
                    </form>

                    <script>
                        let currentSlide = 0;
                        const slides = document.querySelectorAll('#mainCarousel > div');
                        const totalSlides = slides.length;
                        let slideInterval;

                        function updateCarousel() {
                            const carousel = document.getElementById('mainCarousel');
                            carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
                            
                            // Update thumbnail selection
                            document.querySelectorAll('.thumbnail-nav img').forEach((thumb, index) => {
                                if (index === currentSlide) {
                                    thumb.classList.add('ring-2', 'ring-blue-500');
                                } else {
                                    thumb.classList.remove('ring-2', 'ring-blue-500');
                                }
                            });

                            // Update delete button form action
                            const deleteForm = document.querySelector('.absolute.top-2.right-2 form');
                            if (deleteForm) {
                                const currentImage = document.querySelectorAll('.thumbnail-nav img')[currentSlide];
                                const imageId = currentImage.getAttribute('data-image-id');
                                deleteForm.action = `/user/cars/images/${imageId}`;
                            }
                        }

                        function nextSlide() {
                            currentSlide = (currentSlide + 1) % totalSlides;
                            updateCarousel();
                        }

                        function prevSlide() {
                            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                            updateCarousel();
                        }

                        function goToSlide(index) {
                            currentSlide = index;
                            updateCarousel();
                        }

                        function startSlideShow() {
                            stopSlideShow(); // Clear any existing interval
                            slideInterval = setInterval(nextSlide, 5000);
                        }

                        function stopSlideShow() {
                            if (slideInterval) {
                                clearInterval(slideInterval);
                            }
                        }

                        // Start slideshow when page loads
                        document.addEventListener('DOMContentLoaded', function() {
                            startSlideShow();
                            
                            // Stop slideshow when user interacts with navigation
                            document.querySelectorAll('.thumbnail-nav img, button[onclick^="prevSlide"], button[onclick^="nextSlide"]')
                                .forEach(element => {
                                    element.addEventListener('click', stopSlideShow);
                                });
                        });

                        // Form submission handling
                        document.addEventListener('DOMContentLoaded', function() {
                            const form = document.getElementById('updateCarForm');
                            
                            form.addEventListener('submit', function(e) {
                                e.preventDefault();
                                console.log('Form submitted');
                                this.submit();
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 