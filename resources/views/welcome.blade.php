<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ECars - Find Your Perfect Car</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom mb-4">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ route('welcome') }}">ECars</a>
                <div class="d-flex align-items-center">
                    @auth
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

        <main class="container py-5">
            <form method="GET" class="mb-4 d-flex justify-content-end gap-2">
                <label class="me-2 fw-semibold" for="make">Brand:</label>
                <select name="make" id="make" class="form-select w-auto" onchange="this.form.submit()">
                    <option value="all" {{ ($make ?? '') === 'all' ? 'selected' : '' }}>All Brands</option>
                    @foreach($makes as $brand)
                        <option value="{{ $brand }}" {{ ($make ?? '') === $brand ? 'selected' : '' }}>{{ $brand }}</option>
                    @endforeach
                </select>
                <label class="ms-3 me-2 fw-semibold" for="sort_price">Sort by price:</label>
                <select name="sort_price" id="sort_price" class="form-select w-auto" onchange="this.form.submit()">
                    <option value="default" {{ ($sort_price ?? '') === 'default' ? 'selected' : '' }}>Default</option>
                    <option value="price_asc" {{ ($sort_price ?? '') === 'price_asc' ? 'selected' : '' }}>Cheapest first</option>
                    <option value="price_desc" {{ ($sort_price ?? '') === 'price_desc' ? 'selected' : '' }}>Most expensive first</option>
                </select>
                <label class="ms-3 me-2 fw-semibold" for="sort_year">Sort by year:</label>
                <select name="sort_year" id="sort_year" class="form-select w-auto" onchange="this.form.submit()">
                    <option value="default" {{ ($sort_year ?? '') === 'default' ? 'selected' : '' }}>Default</option>
                    <option value="year_desc" {{ ($sort_year ?? '') === 'year_desc' ? 'selected' : '' }}>Newest first</option>
                    <option value="year_asc" {{ ($sort_year ?? '') === 'year_asc' ? 'selected' : '' }}>Oldest first</option>
                </select>
            </form>
            <div class="row g-4">
                @forelse($cars as $car)
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card h-100" style="min-height: 370px;">
                            @if($car->images->isNotEmpty())
                                <img src="{{ Storage::url($car->images->first()->image_path) }}"
                                     class="card-img-top"
                                     style="height: 180px; object-fit: contain; width: 100%; background: #f8f9fa;"
                                     alt="{{ $car->full_name }}">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                     style="height: 180px;">
                                    <span class="text-muted">No image available</span>
                                </div>
                            @endif
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title text-truncate">{{ $car->full_name }}</h5>
                                    <p class="card-text text-muted small mb-2">Posted by {{ $car->user->name }}</p>
                                </div>
                                <div class="text-end mt-auto">
                                    @auth
                                        <a href="{{ route('cars.show', $car) }}" class="btn btn-primary btn-sm rounded-pill px-3 d-inline-flex align-items-center gap-1">
                                            View more <span class="ms-1">&rarr;</span>
                                        </a>
                                    @else
                                        <a href="{{ route('login', ['redirect' => route('cars.show', $car)]) }}" class="btn btn-primary btn-sm rounded-pill px-3 d-inline-flex align-items-center gap-1">
                                            View more <span class="ms-1">&rarr;</span>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted fs-5">No cars available at the moment.</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-4 d-flex flex-column align-items-center">
                <div>
                    {{ $cars->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </main>

        <footer class="bg-white border-top mt-5 py-4">
            <div class="container text-center text-muted small">
                &copy; {{ date('Y') }} ECars. All rights reserved.
            </div>
        </footer>
        <!-- Bootstrap JS (optional, for dropdowns etc.) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
