<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ECars - Find Your Perfect Car</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            :root {
                --primary-color: #2563eb;
                --secondary-color: #1e40af;
                --background-color: #f8fafc;
                --card-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            }
            
            body {
                font-family: 'Inter', sans-serif;
                background-color: var(--background-color);
            }

            .navbar {
                box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
                padding: 1rem 0;
            }

            .navbar-brand {
                font-size: 1.5rem;
                color: var(--primary-color) !important;
            }

            .hero-section {
                background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
                color: white;
                padding: 4rem 0;
                margin-bottom: 3rem;
            }

            .filter-section {
                background: white;
                padding: 1.5rem;
                border-radius: 1rem;
                box-shadow: var(--card-shadow);
                margin-bottom: 2rem;
            }

            .card {
                border: none;
                border-radius: 1rem;
                box-shadow: var(--card-shadow);
                transition: transform 0.2s ease-in-out;
            }

            .card:hover {
                transform: translateY(-5px);
            }

            .card-img-top {
                border-top-left-radius: 1rem;
                border-top-right-radius: 1rem;
                background: #f8f9fa;
            }

            .btn-primary {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
            }

            .btn-primary:hover {
                background-color: var(--secondary-color);
                border-color: var(--secondary-color);
            }

            .btn-outline-primary {
                color: var(--primary-color);
                border-color: var(--primary-color);
            }

            .btn-outline-primary:hover {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
            }

            .form-select {
                border-radius: 0.5rem;
                border: 1px solid #e2e8f0;
            }

            .pagination {
                margin-top: 2rem;
            }

            .page-link {
                color: var(--primary-color);
            }

            .page-item.active .page-link {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
            }

            footer {
                background: white;
                box-shadow: 0 -1px 3px 0 rgb(0 0 0 / 0.1);
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ route('welcome') }}">ECars</a>
                <div class="d-flex align-items-center">
                    @auth
                        @if(auth()->user()->isUser())
                            <a href="{{ route('appointments.index') }}" class="btn btn-outline-primary btn-sm me-2">My Appointments</a>
                        @endif
                        <a href="{{ route('dashboard') }}" class="nav-link me-2">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm me-2">Log in</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                    @endauth
                </div>
            </div>
        </nav>

        <section class="hero-section">
            <div class="container text-center">
                <h1 class="display-4 fw-bold mb-3">Find Your Dream Car</h1>
                <p class="lead mb-0">Browse through our extensive collection of premium vehicles</p>
            </div>
        </section>

        <main class="container py-5">
            <div class="filter-section">
                <form method="GET" class="row g-3 align-items-center">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" for="search">Search</label>
                        <input type="text" name="search" id="search" class="form-control" placeholder="Search by name or model" value="{{ old('search', $search) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" for="make">Brand</label>
                        <select name="make" id="make" class="form-select">
                            <option value="all" {{ ($make ?? '') === 'all' ? 'selected' : '' }}>All Brands</option>
                            @foreach($makes as $brand)
                                <option value="{{ $brand }}" {{ ($make ?? '') === $brand ? 'selected' : '' }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" for="fuel">Fuel Type</label>
                        <select name="fuel" id="fuel" class="form-select">
                            <option value="all" {{ ($fuel ?? '') === 'all' ? 'selected' : '' }}>All Fuel Types</option>
                            @foreach($fuels as $fuelType)
                                <option value="{{ $fuelType }}" {{ ($fuel ?? '') === $fuelType ? 'selected' : '' }}>{{ $fuelType }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" for="location">Location</label>
                        <select name="location" id="location" class="form-select">
                            <option value="all" {{ ($location ?? '') === 'all' ? 'selected' : '' }}>All Locations</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc }}" {{ ($location ?? '') === $loc ? 'selected' : '' }}>{{ $loc }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" for="gearbox">Gearbox</label>
                        <select name="gearbox" id="gearbox" class="form-select">
                            <option value="all" {{ ($gearbox ?? '') === 'all' ? 'selected' : '' }}>All Gearboxes</option>
                            @foreach($gearboxes as $gb)
                                <option value="{{ $gb }}" {{ ($gearbox ?? '') === $gb ? 'selected' : '' }}>{{ $gb }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex flex-column flex-md-row align-items-md-end gap-2">
                        <div class="w-100">
                            <label class="form-label fw-semibold" for="mileage_min">Mileage Min</label>
                            <input type="number" name="mileage_min" id="mileage_min" class="form-control" placeholder="Min" min="0" value="{{ old('mileage_min', $mileage_min) }}">
                        </div>
                        <div class="w-100">
                            <label class="form-label fw-semibold" for="mileage_max">Mileage Max</label>
                            <input type="number" name="mileage_max" id="mileage_max" class="form-control" placeholder="Max" min="0" value="{{ old('mileage_max', $mileage_max) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" for="sort_price">Price</label>
                        <select name="sort_price" id="sort_price" class="form-select">
                            <option value="default" {{ ($sort_price ?? '') === 'default' ? 'selected' : '' }}>Default</option>
                            <option value="price_asc" {{ ($sort_price ?? '') === 'price_asc' ? 'selected' : '' }}>Cheapest first</option>
                            <option value="price_desc" {{ ($sort_price ?? '') === 'price_desc' ? 'selected' : '' }}>Most expensive first</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" for="sort_year">Year</label>
                        <select name="sort_year" id="sort_year" class="form-select">
                            <option value="default" {{ ($sort_year ?? '') === 'default' ? 'selected' : '' }}>Default</option>
                            <option value="year_desc" {{ ($sort_year ?? '') === 'year_desc' ? 'selected' : '' }}>Newest first</option>
                            <option value="year_asc" {{ ($sort_year ?? '') === 'year_asc' ? 'selected' : '' }}>Oldest first</option>
                        </select>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-5">Filter</button>
                    </div>
                </form>
            </div>

            <div class="row g-4">
                @forelse($cars as $car)
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card h-100">
                            @if($car->images->isNotEmpty())
                                <img src="{{ Storage::url($car->images->first()->image_path) }}"
                                     class="card-img-top"
                                     style="height: 200px; object-fit: contain;"
                                     alt="{{ $car->full_name }}">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                     style="height: 200px;">
                                    <span class="text-muted">No image available</span>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-2">{{ $car->full_name }}</h5>
                                <p class="card-text text-muted small mb-3">Posted by {{ $car->user->name }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-primary fw-bold">${{ number_format($car->price) }}</span>
                                    @auth
                                        <a href="{{ route('cars.show', $car) }}" class="btn btn-primary btn-sm rounded-pill px-4">
                                            View Details
                                        </a>
                                    @else
                                        <a href="{{ route('login', ['redirect' => route('cars.show', $car)]) }}" class="btn btn-primary btn-sm rounded-pill px-4">
                                            View Details
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="bg-white rounded-3 p-5 shadow-sm">
                            <h3 class="text-muted mb-0">No cars available at the moment</h3>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="mt-5 d-flex justify-content-center">
                {{ $cars->links('pagination::bootstrap-5') }}
            </div>
        </main>

        <footer class="py-4 mt-5">
            <div class="container text-center text-muted">
                <p class="mb-0">&copy; {{ date('Y') }} ECars. All rights reserved.</p>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
