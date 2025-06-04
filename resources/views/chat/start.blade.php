<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Start a Conversation
            </h2>
            <a href="{{ route('cars.show', $car) }}" class="inline-flex items-center gap-2 px-5 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg shadow hover:bg-gray-300 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 fade-in">
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-6">
                <!-- Car Info -->
                <div class="flex items-center gap-4 mb-6">
                    @if($car->images->count() > 0)
                        <img src="{{ Storage::url($car->images->first()->image_path) }}" alt="Car" class="w-20 h-20 rounded-lg object-cover border">
                    @else
                        <span class="w-20 h-20 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 text-3xl">🚗</span>
                    @endif
                    <div>
                        <div class="font-bold text-lg text-gray-900">{{ $car->year }} {{ $car->make }} {{ $car->model }}</div>
                        <div class="flex flex-wrap gap-2 mt-1">
                            <span class="inline-block px-2 py-0.5 rounded bg-blue-100 text-blue-700 text-xs font-semibold">{{ $car->year }}</span>
                            <span class="inline-block px-2 py-0.5 rounded bg-gray-200 text-gray-700 text-xs font-semibold">{{ number_format($car->mileage) }} km</span>
                            <span class="inline-block px-2 py-0.5 rounded bg-yellow-100 text-yellow-700 text-xs font-semibold">{{ $car->fuel }}</span>
                            <span class="inline-block px-2 py-0.5 rounded bg-purple-100 text-purple-700 text-xs font-semibold">{{ $car->gearbox }}</span>
                        </div>
                        <div class="mt-2">
                            <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 font-bold text-sm">€{{ number_format($car->price, 2) }}</span>
                        </div>
                    </div>
                </div>
                <!-- Seller Info -->
                <div class="flex items-center gap-4 mb-8">
                    <span class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xl border">{{ strtoupper(substr($car->user->name, 0, 1)) }}</span>
                    <div>
                        <div class="font-semibold text-gray-900">{{ $car->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $car->user->email }}</div>
                    </div>
                </div>
                <!-- Start Chat Form -->
                <form action="{{ route('chat.store', [$car->id, $car->user_id]) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Your Message</label>
                            <textarea name="message" id="message" rows="5"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                      placeholder="Write your message to the seller..." required></textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Send Message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Add fade-in animation to card
        document.addEventListener('DOMContentLoaded', function() {
            const fadeEls = document.querySelectorAll('.fade-in');
            fadeEls.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    el.style.transition = 'all 0.5s ease-out';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
    @endpush
</x-app-layout> 