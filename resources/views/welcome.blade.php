<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ECars - Find Your Perfect Car</title>
        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
            .nav-scrolled {
                @apply bg-white/80 backdrop-blur-md shadow-md;
            }
        </style>
    </head>
    <body class="bg-slate-50">
        <nav class="sticky top-0 z-50 py-4 bg-white/80 backdrop-blur-md transition-all duration-300" id="main-nav">
            <div class="container mx-auto flex justify-between items-center px-4">
                <a class="text-2xl font-bold text-blue-600 hover:text-blue-800 transition flex items-center gap-2" href="{{ route('welcome') }}">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                    </svg>
                    ECars
                </a>
                <div class="flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->isUser())
                            <a href="{{ route('appointments.index') }}" class="inline-flex items-center gap-2 text-gray-700 hover:text-blue-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                My Appointments
                            </a>
                        @endif
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-gray-700 hover:text-blue-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 border border-red-500 text-red-500 px-4 py-2 rounded-lg hover:bg-red-500 hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 border border-blue-600 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-600 hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </nav>

        <section class="relative bg-gradient-to-br from-blue-600 to-blue-900 text-white py-24 mb-12 overflow-hidden">
            <div class="absolute inset-0 opacity-20 pointer-events-none select-none">
                <svg width="100%" height="100%" viewBox="0 0 1440 320" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#fff" fill-opacity="0.2" d="M0,160L60,170.7C120,181,240,203,360,197.3C480,192,600,160,720,133.3C840,107,960,85,1080,101.3C1200,117,1320,171,1380,197.3L1440,224L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
                </svg>
            </div>
            <div class="container mx-auto text-center px-4 relative z-10">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 drop-shadow-lg">Find Your Dream Car</h1>
                <p class="text-lg md:text-xl mb-8 drop-shadow max-w-2xl mx-auto">Browse through our extensive collection of premium vehicles and find the perfect match for your lifestyle</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#car-listings" id="browse-cars-btn" class="inline-flex items-center justify-center gap-2 bg-white text-blue-700 font-bold px-8 py-4 rounded-xl shadow-lg hover:bg-blue-50 hover:text-blue-900 transition text-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Browse Cars
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 bg-blue-500 text-white font-bold px-8 py-4 rounded-xl shadow-lg hover:bg-blue-600 transition text-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Join Now
                        </a>
                    @endguest
                </div>
            </div>
        </section>

        <main class="container mx-auto py-12 px-4">
            <div class="bg-white/80 border border-slate-200 p-8 rounded-2xl shadow-lg mb-12 backdrop-blur-md">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter Cars
                </h2>
                <form method="GET" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <div>
                        <label class="font-semibold block mb-2 text-gray-700" for="search">Search</label>
                        <div class="relative">
                            <input type="text" name="search" id="search" class="w-full rounded-lg border border-slate-300 px-4 py-2 pr-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition placeholder-gray-400" placeholder="Search by name or model" value="{{ old('search', $search) }}">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" /></svg>
                            </span>
                        </div>
                    </div>
                    <div>
                        <label class="font-semibold block mb-2 text-gray-700" for="make">Brand</label>
                        <div class="relative">
                            <select name="make" id="make" class="w-full rounded-lg border border-slate-300 px-4 py-2 pl-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="all" {{ ($make ?? '') === 'all' ? 'selected' : '' }}>All Brands</option>
                                @foreach($makes as $brand)
                                    <option value="{{ $brand }}" {{ ($make ?? '') === $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                @endforeach
                            </select>
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-blue-400 pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13l2-2m0 0l7-7 7 7M5 11v8a2 2 0 002 2h10a2 2 0 002-2v-8" /></svg>
                            </span>
                        </div>
                    </div>
                    <div>
                        <label class="font-semibold block mb-2 text-gray-700" for="fuel">Fuel Type</label>
                        <div class="relative">
                            <select name="fuel" id="fuel" class="w-full rounded-lg border border-slate-300 px-4 py-2 pl-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="all" {{ ($fuel ?? '') === 'all' ? 'selected' : '' }}>All Fuel Types</option>
                                @foreach($fuels as $fuelType)
                                    <option value="{{ $fuelType }}" {{ ($fuel ?? '') === $fuelType ? 'selected' : '' }}>{{ $fuelType }}</option>
                                @endforeach
                            </select>
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-yellow-500 pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="13" height="18" rx="2"/><path d="M16 7v8a2 2 0 002 2h1a2 2 0 002-2v-5a2 2 0 00-2-2h-1"/></svg>
                            </span>
                        </div>
                    </div>
                    <div>
                        <label class="font-semibold block mb-2 text-gray-700" for="location">Location</label>
                        <div class="relative">
                            <select name="location" id="location" class="w-full rounded-lg border border-slate-300 px-4 py-2 pl-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="all" {{ ($location ?? '') === 'all' ? 'selected' : '' }}>All Locations</option>
                                @foreach($locations as $loc)
                                    <option value="{{ $loc }}" {{ ($location ?? '') === $loc ? 'selected' : '' }}>{{ $loc }}</option>
                                @endforeach
                            </select>
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21C12 21 7 16.5 7 12A5 5 0 0117 12c0 4.5-5 9-5 9z"/><circle cx="12" cy="12" r="2"/></svg>
                            </span>
                        </div>
                    </div>
                    <div>
                        <label class="font-semibold block mb-2 text-gray-700" for="gearbox">Gearbox</label>
                        <div class="relative">
                            <select name="gearbox" id="gearbox" class="w-full rounded-lg border border-slate-300 px-4 py-2 pl-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="all" {{ ($gearbox ?? '') === 'all' ? 'selected' : '' }}>All Gearboxes</option>
                                @foreach($gearboxes as $gb)
                                    <option value="{{ $gb }}" {{ ($gearbox ?? '') === $gb ? 'selected' : '' }}>{{ $gb }}</option>
                                @endforeach
                            </select>
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-purple-500 pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09a1.65 1.65 0 00-1-1.51 1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09a1.65 1.65 0 001.51-1 1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06a1.65 1.65 0 001.82.33h.09A1.65 1.65 0 0011 3.09V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51h.09a1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82v.09c0 .66.26 1.3.73 1.77.47.47 1.11.73 1.77.73h.09a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                            </span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="font-semibold block mb-2 text-gray-700" for="mileage_min">Mileage Min</label>
                            <input type="number" name="mileage_min" id="mileage_min" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Min" min="0" value="{{ old('mileage_min', $mileage_min) }}">
                        </div>
                        <div>
                            <label class="font-semibold block mb-2 text-gray-700" for="mileage_max">Mileage Max</label>
                            <input type="number" name="mileage_max" id="mileage_max" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Max" min="0" value="{{ old('mileage_max', $mileage_max) }}">
                        </div>
                    </div>
                    <div class="relative">
                        <label class="font-semibold block mb-2 text-gray-700" for="sort_price">Price</label>
                        <select name="sort_price" id="sort_price" class="w-full rounded-lg border border-slate-300 px-4 py-2 pl-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="default" {{ ($sort_price ?? '') === 'default' ? 'selected' : '' }}>Default</option>
                            <option value="price_asc" {{ ($sort_price ?? '') === 'price_asc' ? 'selected' : '' }}>Cheapest first</option>
                            <option value="price_desc" {{ ($sort_price ?? '') === 'price_desc' ? 'selected' : '' }}>Most expensive first</option>
                        </select>
                        <span class="pointer-events-none absolute left-3 top-1/2" style="transform: translateY(20%);">
                            <!-- Money/banknote icon -->
                            <svg class="w-5 h-5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <rect x="2" y="7" width="20" height="10" rx="2"/>
                              <circle cx="12" cy="12" r="3"/>
                              <path d="M2 10h.01M22 10h-.01M2 14h.01M22 14h-.01"/>
                            </svg>
                        </span>
                    </div>
                    <div class="relative">
                        <label class="font-semibold block mb-2 text-gray-700" for="sort_year">Year</label>
                        <select name="sort_year" id="sort_year" class="w-full rounded-lg border border-slate-300 px-4 py-2 pl-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="default" {{ ($sort_year ?? '') === 'default' ? 'selected' : '' }}>Default</option>
                            <option value="year_desc" {{ ($sort_year ?? '') === 'year_desc' ? 'selected' : '' }}>Newest first</option>
                            <option value="year_asc" {{ ($sort_year ?? '') === 'year_asc' ? 'selected' : '' }}>Oldest first</option>
                        </select>
                        <span class="pointer-events-none absolute left-3 top-1/2" style="transform: translateY(10%);">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                        </span>
                    </div>
                    <div class="flex items-end justify-end col-span-1 md:col-span-3 lg:col-span-4">
                        <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold shadow hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                            <svg class="h-5 w-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <div id="car-listings" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                @forelse($cars as $car)
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-shadow duration-200 border flex flex-col overflow-hidden group">
                        <div class="relative w-full aspect-w-16 aspect-h-9 bg-gray-100 flex items-center justify-center">
                            @if($car->images->count() > 0)
                                <img src="{{ Storage::url($car->images->first()->image_path) }}"
                                     alt="{{ $car->full_name }}"
                                     class="w-full h-full object-cover rounded-t-2xl transition-transform duration-200 group-hover:scale-105">
                            @else
                                <span class="text-gray-400">No Image</span>
                            @endif
                        </div>
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <h4 class="font-bold text-lg mb-2 text-gray-900 truncate">{{ $car->full_name }}</h4>
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <span class="inline-block px-2 py-0.5 rounded bg-blue-100 text-blue-700 text-xs font-semibold">{{ $car->year }}</span>
                                    <span class="inline-block px-2 py-0.5 rounded bg-gray-200 text-gray-700 text-xs font-semibold">{{ number_format($car->mileage) }} km</span>
                                    <span class="inline-block px-2 py-0.5 rounded bg-yellow-100 text-yellow-700 text-xs font-semibold">{{ $car->fuel }}</span>
                                    <span class="inline-block px-2 py-0.5 rounded bg-purple-100 text-purple-700 text-xs font-semibold">{{ $car->gearbox }}</span>
                                </div>
                                <div class="mb-2">
                                    <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 font-bold text-sm">€{{ number_format($car->price, 2) }}</span>
                                </div>
                                <div class="mb-2 text-gray-600 text-sm">
                                    <span class="font-medium">Location:</span> {{ $car->location }}
                                </div>
                                <div class="mb-2 text-gray-600 text-sm flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>Posted by: {{ $car->user->name }}</span>
                                </div>
                            </div>
                            <div class="mt-4">
                                @auth
                                    <a href="{{ route('cars.show', $car) }}" class="w-full bg-blue-600 text-white text-center rounded-lg px-4 py-2 hover:bg-blue-700 transition">
                                        View Details
                                    </a>
                                @else
                                    <a href="{{ route('login', ['redirect' => route('cars.show', $car)]) }}" class="w-full bg-blue-600 text-white text-center rounded-lg px-4 py-2 hover:bg-blue-700 transition">
                                        View Details
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <div class="bg-white rounded-3xl p-10 shadow">
                            <h3 class="text-gray-400 mb-0">No cars available at the moment</h3>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="mt-12 flex justify-center">
                @if ($cars->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center space-x-2 select-none">
                        {{-- Previous Page Link --}}
                        @if ($cars->onFirstPage())
                            <span class="px-3 py-1 rounded border border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed">&laquo;</span>
                        @else
                            <a href="{{ $cars->previousPageUrl() }}" class="px-3 py-1 rounded border border-gray-200 bg-white text-blue-600 hover:bg-blue-50 transition">&laquo;</a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($cars->links()->elements[0] as $page => $url)
                            @if ($page == $cars->currentPage())
                                <span class="px-3 py-1 rounded border border-blue-600 bg-blue-600 text-white font-semibold">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-1 rounded border border-gray-200 bg-white text-blue-600 hover:bg-blue-50 transition">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($cars->hasMorePages())
                            <a href="{{ $cars->nextPageUrl() }}" class="px-3 py-1 rounded border border-gray-200 bg-white text-blue-600 hover:bg-blue-50 transition">&raquo;</a>
                        @else
                            <span class="px-3 py-1 rounded border border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed">&raquo;</span>
                        @endif
                    </nav>
                @endif
            </div>
        </main>

        <footer class="py-12 mt-12 bg-white shadow-inner">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">About ECars</h3>
                        <p class="text-gray-600">Your trusted platform for finding the perfect car. We connect buyers and sellers in a seamless, secure environment.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Links</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">How it Works</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Pricing</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">FAQ</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Contact Us</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Contact</h3>
                        <ul class="space-y-2">
                            <li class="flex items-center gap-2 text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                support@ecars.com
                            </li>
                            <li class="flex items-center gap-2 text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                +38972547373
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Follow Us</h3>
                        <div class="flex gap-4">
                            <a href="#" class="text-gray-600 hover:text-blue-600 transition" title="Twitter">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557a9.93 9.93 0 01-2.828.775 4.932 4.932 0 002.165-2.724c-.951.564-2.005.974-3.127 1.195A4.92 4.92 0 0016.616 3c-2.73 0-4.942 2.21-4.942 4.932 0 .386.045.762.127 1.124C7.728 8.807 4.1 6.884 1.671 3.965c-.423.722-.666 1.561-.666 2.475 0 1.708.87 3.216 2.188 4.099a4.904 4.904 0 01-2.237-.616c-.054 2.281 1.581 4.415 3.949 4.89a4.936 4.936 0 01-2.224.084c.627 1.956 2.444 3.377 4.6 3.417A9.867 9.867 0 010 21.543a13.94 13.94 0 007.548 2.209c9.057 0 14.009-7.496 14.009-13.986 0-.213-.005-.425-.014-.636A9.936 9.936 0 0024 4.557z"/></svg>
                            </a>
                            <a href="#" class="text-gray-600 hover:text-blue-600 transition" title="Facebook">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35C.597 0 0 .592 0 1.326v21.348C0 23.408.597 24 1.326 24H12.82v-9.294H9.692v-3.622h3.127V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.797.143v3.24l-1.918.001c-1.504 0-1.797.715-1.797 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116C23.403 24 24 23.408 24 22.674V1.326C24 .592 23.403 0 22.675 0"/></svg>
                            </a>
                            <a href="#" class="text-gray-600 hover:text-blue-600 transition" title="Instagram">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.974.974 1.246 2.241 1.308 3.608.058 1.266.069 1.646.069 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.974.974-2.241 1.246-3.608 1.308-1.266.058-1.646.069-4.85.069s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.308-.974-.974-1.246-2.241-1.308-3.608C2.175 15.647 2.163 15.267 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608C4.515 2.497 5.782 2.225 7.148 2.163 8.414 2.105 8.794 2.094 12 2.094m0-2.163C8.741 0 8.332.012 7.052.07 5.771.128 4.659.334 3.678 1.315c-.98.98-1.187 2.092-1.245 3.373C2.012 8.332 2 8.741 2 12c0 3.259.012 3.668.07 4.948.058 1.281.265 2.393 1.245 3.373.98.98 2.092 1.187 3.373 1.245C8.332 23.988 8.741 24 12 24s3.668-.012 4.948-.07c1.281-.058 2.393-.265 3.373-1.245.98-.98 1.187-2.092 1.245-3.373.058-1.28.07-1.689.07-4.948 0-3.259-.012-3.668-.07-4.948-.058-1.281-.265-2.393-1.245-3.373-.98-.98-2.092-1.187-3.373-1.245C15.668.012 15.259 0 12 0zm0 5.838A6.162 6.162 0 0 0 5.838 12 6.162 6.162 0 0 0 12 18.162 6.162 6.162 0 0 0 18.162 12 6.162 6.162 0 0 0 12 5.838zm0 10.162A3.999 3.999 0 1 1 12 8a3.999 3.999 0 0 1 0 7.999zm6.406-11.845a1.44 1.44 0 1 0 0 2.88 1.44 1.44 0 0 0 0-2.88z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-200 pt-8 text-center">
                    <p class="text-gray-600 mb-4">&copy; {{ date('Y') }} ECars. All rights reserved.</p>
                    <button id="back-to-top" class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-full shadow-lg hover:bg-blue-700 hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 text-sm font-semibold opacity-0 invisible" onclick="scrollToTop()" aria-label="Back to top">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        Back to Top
                    </button>
                </div>
            </div>
        </footer>

        <script>
            // Add scroll event listener for navbar
            window.addEventListener('scroll', function() {
                const nav = document.getElementById('main-nav');
                const backToTopBtn = document.getElementById('back-to-top');
                
                if (window.scrollY > 50) {
                    nav.classList.add('nav-scrolled');
                } else {
                    nav.classList.remove('nav-scrolled');
                }
                
                // Show/hide back to top button
                if (window.scrollY > 300) {
                    backToTopBtn.classList.remove('opacity-0', 'invisible');
                    backToTopBtn.classList.add('opacity-100', 'visible');
                } else {
                    backToTopBtn.classList.add('opacity-0', 'invisible');
                    backToTopBtn.classList.remove('opacity-100', 'visible');
                }
            });
            
            // Smooth scroll to top function
            function scrollToTop() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                const browseBtn = document.getElementById('browse-cars-btn');
                if (browseBtn) {
                    browseBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const target = document.getElementById('car-listings');
                        if (target) {
                            target.scrollIntoView({ behavior: 'smooth' });
                        }
                    });
                }
            });
        </script>
    </body>
</html>
