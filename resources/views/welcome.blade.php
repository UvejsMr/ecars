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
        </style>
    </head>
    <body class="bg-slate-50">
        <nav class="shadow-sm py-4 bg-white">
            <div class="container mx-auto flex justify-between items-center px-4">
                <a class="text-2xl font-bold text-blue-600" href="{{ route('welcome') }}">ECars</a>
                <div class="flex items-center space-x-2">
                    @auth
                        @if(auth()->user()->isUser())
                            <a href="{{ route('appointments.index') }}" class="btn btn-outline-primary btn-sm me-2 border border-blue-600 text-blue-600 px-3 py-1 rounded hover:bg-blue-600 hover:text-white transition">My Appointments</a>
                        @endif
                        <a href="{{ route('dashboard') }}" class="nav-link me-2 text-gray-700 hover:text-blue-600 transition">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="border border-red-500 text-red-500 px-3 py-1 rounded hover:bg-red-500 hover:text-white transition">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="border border-blue-600 text-blue-600 px-3 py-1 rounded hover:bg-blue-600 hover:text-white transition">Log in</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-3 py-1 rounded ml-2 hover:bg-blue-800 transition">Register</a>
                    @endauth
                </div>
            </div>
        </nav>

        <section class="bg-gradient-to-br from-blue-600 to-blue-900 text-white py-16 mb-12">
            <div class="container mx-auto text-center px-4">
                <h1 class="text-4xl md:text-5xl font-bold mb-3">Find Your Dream Car</h1>
                <p class="text-lg md:text-xl mb-0">Browse through our extensive collection of premium vehicles</p>
            </div>
        </section>

        <main class="container mx-auto py-12 px-4">
            <div class="bg-white/90 border border-slate-200 p-8 rounded-2xl shadow mb-10">
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
                        <select name="make" id="make" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="all" {{ ($make ?? '') === 'all' ? 'selected' : '' }}>All Brands</option>
                            @foreach($makes as $brand)
                                <option value="{{ $brand }}" {{ ($make ?? '') === $brand ? 'selected' : '' }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="font-semibold block mb-2 text-gray-700" for="fuel">Fuel Type</label>
                        <select name="fuel" id="fuel" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="all" {{ ($fuel ?? '') === 'all' ? 'selected' : '' }}>All Fuel Types</option>
                            @foreach($fuels as $fuelType)
                                <option value="{{ $fuelType }}" {{ ($fuel ?? '') === $fuelType ? 'selected' : '' }}>{{ $fuelType }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="font-semibold block mb-2 text-gray-700" for="location">Location</label>
                        <select name="location" id="location" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="all" {{ ($location ?? '') === 'all' ? 'selected' : '' }}>All Locations</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc }}" {{ ($location ?? '') === $loc ? 'selected' : '' }}>{{ $loc }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="font-semibold block mb-2 text-gray-700" for="gearbox">Gearbox</label>
                        <select name="gearbox" id="gearbox" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="all" {{ ($gearbox ?? '') === 'all' ? 'selected' : '' }}>All Gearboxes</option>
                            @foreach($gearboxes as $gb)
                                <option value="{{ $gb }}" {{ ($gearbox ?? '') === $gb ? 'selected' : '' }}>{{ $gb }}</option>
                            @endforeach
                        </select>
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
                    <div>
                        <label class="font-semibold block mb-2 text-gray-700" for="sort_price">Price</label>
                        <select name="sort_price" id="sort_price" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="default" {{ ($sort_price ?? '') === 'default' ? 'selected' : '' }}>Default</option>
                            <option value="price_asc" {{ ($sort_price ?? '') === 'price_asc' ? 'selected' : '' }}>Cheapest first</option>
                            <option value="price_desc" {{ ($sort_price ?? '') === 'price_desc' ? 'selected' : '' }}>Most expensive first</option>
                        </select>
                    </div>
                    <div>
                        <label class="font-semibold block mb-2 text-gray-700" for="sort_year">Year</label>
                        <select name="sort_year" id="sort_year" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="default" {{ ($sort_year ?? '') === 'default' ? 'selected' : '' }}>Default</option>
                            <option value="year_desc" {{ ($sort_year ?? '') === 'year_desc' ? 'selected' : '' }}>Newest first</option>
                            <option value="year_asc" {{ ($sort_year ?? '') === 'year_asc' ? 'selected' : '' }}>Oldest first</option>
                        </select>
                    </div>
                    <div class="flex items-end justify-end col-span-1 md:col-span-3 lg:col-span-4">
                        <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold shadow hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" /><circle cx="12" cy="7" r="4" /></svg>
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @forelse($cars as $car)
                    <div class="h-full">
                        <div class="bg-white rounded-2xl shadow h-full flex flex-col">
                            @if($car->images->isNotEmpty())
                                <img src="{{ Storage::url($car->images->first()->image_path) }}"
                                     class="rounded-t-2xl w-full h-[200px] object-contain bg-slate-100"
                                     alt="{{ $car->full_name }}">
                            @else
                                <div class="bg-slate-100 flex items-center justify-center h-[200px] rounded-t-2xl">
                                    <span class="text-gray-400">No image available</span>
                                </div>
                            @endif
                            <div class="p-4 flex flex-col flex-1">
                                <h5 class="font-bold text-lg mb-2">{{ $car->full_name }}</h5>
                                <p class="text-gray-500 text-sm mb-3">Posted by {{ $car->user->name }}</p>
                                <div class="flex justify-between items-center mt-auto">
                                    <span class="text-blue-600 font-bold text-lg">${{ number_format($car->price) }}</span>
                                    @auth
                                        <a href="{{ route('cars.show', $car) }}" class="bg-blue-600 text-white text-sm rounded-full px-4 py-1 hover:bg-blue-800 transition">
                                            View Details
                                        </a>
                                    @else
                                        <a href="{{ route('login', ['redirect' => route('cars.show', $car)]) }}" class="bg-blue-600 text-white text-sm rounded-full px-4 py-1 hover:bg-blue-800 transition">
                                            View Details
                                        </a>
                                    @endauth
                                </div>
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

        <footer class="py-8 mt-12 bg-white shadow-inner">
            <div class="container mx-auto text-center text-gray-400">
                <p class="mb-0">&copy; {{ date('Y') }} ECars. All rights reserved.</p>
            </div>
        </footer>
    </body>
</html>
