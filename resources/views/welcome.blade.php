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
        <nav class="sticky top-0 z-50 shadow-md py-4 bg-white transition-all">
            <div class="container mx-auto flex justify-between items-center px-4">
                <a class="text-2xl font-bold text-blue-600 hover:text-blue-800 transition" href="{{ route('welcome') }}">ECars</a>
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

        <section class="relative bg-gradient-to-br from-blue-600 to-blue-900 text-white py-20 mb-12 overflow-hidden">
            <div class="absolute inset-0 opacity-20 pointer-events-none select-none">
                <svg width="100%" height="100%" viewBox="0 0 1440 320" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#fff" fill-opacity="0.2" d="M0,160L60,170.7C120,181,240,203,360,197.3C480,192,600,160,720,133.3C840,107,960,85,1080,101.3C1200,117,1320,171,1380,197.3L1440,224L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
                </svg>
            </div>
            <div class="container mx-auto text-center px-4 relative z-10">
                <h1 class="text-4xl md:text-5xl font-bold mb-3 drop-shadow-lg">Find Your Dream Car</h1>
                <p class="text-lg md:text-xl mb-6 drop-shadow">Browse through our extensive collection of premium vehicles</p>
                <a href="#car-listings" class="inline-block bg-white text-blue-700 font-bold px-8 py-3 rounded-lg shadow hover:bg-blue-100 hover:text-blue-900 transition text-lg">Browse Cars</a>
            </div>
        </section>

        <main class="container mx-auto py-12 px-4">
            <div class="bg-white/80 border border-slate-200 p-8 rounded-2xl shadow mb-10 backdrop-blur-md">
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
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" /></svg>
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
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-yellow-400 pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            </span>
                        </div>
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

            <div id="car-listings" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @forelse($cars as $car)
                    <div class="h-full">
                        <div class="bg-white rounded-2xl shadow h-full flex flex-col group hover:shadow-xl hover:-translate-y-1 transition-transform relative">
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
                                <div class="flex items-center justify-between mb-2">
                                    <h5 class="font-bold text-lg">{{ $car->full_name }}</h5>
                                    <button class="text-gray-300 hover:text-red-500 transition" title="Favorite">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.293l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.293l-7.682-7.682a4.5 4.5 0 010-6.364z" /></svg>
                                    </button>
                                </div>
                                <div class="flex flex-wrap gap-2 mb-2">
                                    <span class="inline-block px-2 py-0.5 rounded bg-blue-100 text-blue-700 text-xs font-semibold">{{ $car->year }}</span>
                                    <span class="inline-block px-2 py-0.5 rounded bg-gray-200 text-gray-700 text-xs font-semibold">{{ number_format($car->mileage) }} km</span>
                                    <span class="inline-block px-2 py-0.5 rounded bg-yellow-100 text-yellow-700 text-xs font-semibold">{{ $car->fuel }}</span>
                                    <span class="inline-block px-2 py-0.5 rounded bg-purple-100 text-purple-700 text-xs font-semibold">{{ $car->gearbox }}</span>
                                </div>
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-700 text-sm" title="Seller">
                                        {{ substr($car->user->name, 0, 1) }}
                                    </div>
                                    <span class="text-gray-500 text-xs">{{ $car->user->name }}</span>
                                </div>
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
            <div class="container mx-auto text-center text-gray-400 flex flex-col items-center gap-4">
                <div class="flex gap-4 justify-center mb-2">
                    <a href="#" class="hover:text-blue-600" title="Twitter"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557a9.93 9.93 0 01-2.828.775 4.932 4.932 0 002.165-2.724c-.951.564-2.005.974-3.127 1.195A4.92 4.92 0 0016.616 3c-2.73 0-4.942 2.21-4.942 4.932 0 .386.045.762.127 1.124C7.728 8.807 4.1 6.884 1.671 3.965c-.423.722-.666 1.561-.666 2.475 0 1.708.87 3.216 2.188 4.099a4.904 4.904 0 01-2.237-.616c-.054 2.281 1.581 4.415 3.949 4.89a4.936 4.936 0 01-2.224.084c.627 1.956 2.444 3.377 4.6 3.417A9.867 9.867 0 010 21.543a13.94 13.94 0 007.548 2.209c9.057 0 14.009-7.496 14.009-13.986 0-.213-.005-.425-.014-.636A9.936 9.936 0 0024 4.557z"/></svg></a>
                    <a href="#" class="hover:text-blue-600" title="Facebook"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35C.597 0 0 .592 0 1.326v21.348C0 23.408.597 24 1.326 24H12.82v-9.294H9.692v-3.622h3.127V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.797.143v3.24l-1.918.001c-1.504 0-1.797.715-1.797 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116C23.403 24 24 23.408 24 22.674V1.326C24 .592 23.403 0 22.675 0"/></svg></a>
                    <a href="#" class="hover:text-blue-600" title="Instagram"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.974.974 1.246 2.241 1.308 3.608.058 1.266.069 1.646.069 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.974.974-2.241 1.246-3.608 1.308-1.266.058-1.646.069-4.85.069s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.308-.974-.974-1.246-2.241-1.308-3.608C2.175 15.647 2.163 15.267 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608C4.515 2.497 5.782 2.225 7.148 2.163 8.414 2.105 8.794 2.094 12 2.094m0-2.163C8.741 0 8.332.012 7.052.07 5.771.128 4.659.334 3.678 1.315c-.98.98-1.187 2.092-1.245 3.373C2.012 8.332 2 8.741 2 12c0 3.259.012 3.668.07 4.948.058 1.281.265 2.393 1.245 3.373.98.98 2.092 1.187 3.373 1.245C8.332 23.988 8.741 24 12 24s3.668-.012 4.948-.07c1.281-.058 2.393-.265 3.373-1.245.98-.98 1.187-2.092 1.245-3.373.058-1.28.07-1.689.07-4.948 0-3.259-.012-3.668-.07-4.948-.058-1.281-.265-2.393-1.245-3.373-.98-.98-2.092-1.187-3.373-1.245C15.668.012 15.259 0 12 0zm0 5.838A6.162 6.162 0 0 0 5.838 12 6.162 6.162 0 0 0 12 18.162 6.162 6.162 0 0 0 18.162 12 6.162 6.162 0 0 0 12 5.838zm0 10.162A3.999 3.999 0 1 1 12 8a3.999 3.999 0 0 1 0 7.999zm6.406-11.845a1.44 1.44 0 1 0 0 2.88 1.44 1.44 0 0 0 0-2.88z"/></svg></a>
                </div>
                <p class="mb-0">&copy; {{ date('Y') }} ECars. All rights reserved.</p>
                <a href="#" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;" class="inline-block mt-2 text-blue-600 hover:text-blue-900 transition text-sm">Back to top &uarr;</a>
            </div>
        </footer>
    </body>
</html>
