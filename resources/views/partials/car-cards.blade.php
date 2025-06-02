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