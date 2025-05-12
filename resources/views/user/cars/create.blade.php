<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Car') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('user.cars.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Make -->
                            <div>
                                <x-input-label for="make" :value="__('Make')" />
                                <x-text-input id="make" name="make" type="text" class="mt-1 block w-full" :value="old('make')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('make')" />
                            </div>

                            <!-- Model -->
                            <div>
                                <x-input-label for="model" :value="__('Model')" />
                                <x-text-input id="model" name="model" type="text" class="mt-1 block w-full" :value="old('model')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('model')" />
                            </div>

                            <!-- Year -->
                            <div>
                                <x-input-label for="year" :value="__('Year')" />
                                <x-text-input id="year" name="year" type="number" class="mt-1 block w-full" :value="old('year')" required min="1900" max="{{ date('Y') + 1 }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('year')" />
                            </div>

                            <!-- Power -->
                            <div>
                                <x-input-label for="power" :value="__('Power (HP)')" />
                                <x-text-input id="power" name="power" type="number" class="mt-1 block w-full" :value="old('power')" required min="1" />
                                <x-input-error class="mt-2" :messages="$errors->get('power')" />
                            </div>

                            <!-- Mileage -->
                            <div>
                                <x-input-label for="mileage" :value="__('Mileage (km)')" />
                                <x-text-input id="mileage" name="mileage" type="number" class="mt-1 block w-full" :value="old('mileage')" required min="0" />
                                <x-input-error class="mt-2" :messages="$errors->get('mileage')" />
                            </div>

                            <!-- Gearbox -->
                            <div>
                                <x-input-label for="gearbox" :value="__('Gearbox')" />
                                <select id="gearbox" name="gearbox" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select gearbox type</option>
                                    <option value="Manual" {{ old('gearbox') == 'Manual' ? 'selected' : '' }}>Manual</option>
                                    <option value="Automatic" {{ old('gearbox') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                                    <option value="Semi-automatic" {{ old('gearbox') == 'Semi-automatic' ? 'selected' : '' }}>Semi-automatic</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('gearbox')" />
                            </div>

                            <!-- Fuel -->
                            <div>
                                <x-input-label for="fuel" :value="__('Fuel Type')" />
                                <select id="fuel" name="fuel" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select fuel type</option>
                                    <option value="Petrol" {{ old('fuel') == 'Petrol' ? 'selected' : '' }}>Petrol</option>
                                    <option value="Diesel" {{ old('fuel') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                                    <option value="Electric" {{ old('fuel') == 'Electric' ? 'selected' : '' }}>Electric</option>
                                    <option value="Hybrid" {{ old('fuel') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('fuel')" />
                            </div>

                            <!-- Engine Size -->
                            <div>
                                <x-input-label for="engine_size" :value="__('Engine Size (L)')" />
                                <x-text-input id="engine_size" name="engine_size" type="number" step="0.1" class="mt-1 block w-full" :value="old('engine_size')" required min="0.1" />
                                <x-input-error class="mt-2" :messages="$errors->get('engine_size')" />
                            </div>

                            <!-- Price -->
                            <div>
                                <x-input-label for="price" :value="__('Price (€)')" />
                                <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full" :value="old('price')" required min="0" />
                                <x-input-error class="mt-2" :messages="$errors->get('price')" />
                            </div>

                            <!-- Location -->
                            <div>
                                <x-input-label for="location" :value="__('Location')" />
                                <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location')" required />
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
                                               {{ in_array($option, old('equipment', [])) ? 'checked' : '' }}>
                                        <label class="ml-2 text-sm text-gray-600">{{ $option }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('equipment')" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <!-- Images -->
                        <div>
                            <x-input-label for="images" :value="__('Images (up to 10)')" />
                            <input type="file" id="images" name="images[]" multiple accept="image/*" class="mt-1 block w-full" required>
                            <p class="mt-1 text-sm text-gray-500">You can select up to 10 images. Maximum size: 2MB per image.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('images')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Add Car') }}</x-primary-button>
                            <a href="{{ route('user.cars.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 