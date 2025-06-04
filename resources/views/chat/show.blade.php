<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <!-- Car Thumbnail -->
                @if($car->images->count() > 0)
                    <img src="{{ Storage::url($car->images->first()->image_path) }}" alt="Car" class="w-10 h-10 rounded-lg object-cover border">
                @else
                    <span class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 text-xl">🚗</span>
                @endif
                <!-- User Avatar -->
                <span class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-lg border">{{ strtoupper(substr($otherUser->name, 0, 1)) }}</span>
                <span class="font-semibold text-lg text-gray-800">Chat about {{ $car->make }} {{ $car->model }}</span>
            </div>
            <a href="{{ route('chat.index') }}" class="inline-flex items-center gap-2 px-5 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg shadow hover:bg-gray-300 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Conversations
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">Chatting with {{ $otherUser->name }}</h3>
                        <p class="text-sm text-gray-600">About: {{ $car->make }} {{ $car->model }}</p>
                    </div>

                    <div class="space-y-4 mb-6 h-[500px] overflow-y-auto px-4 fade-in" id="chat-messages">
                        @foreach($messages as $message)
                            <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }} items-end gap-2">
                                @if($message->sender_id !== auth()->id())
                                    <span class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm border">{{ strtoupper(substr($otherUser->name, 0, 1)) }}</span>
                                @endif
                                <div class="max-w-[70%] {{ $message->sender_id === auth()->id() ? 'bg-blue-600 text-white ml-auto' : 'bg-gray-100 text-gray-800' }} rounded-2xl px-4 py-2 shadow-md relative">
                                    <p>{{ $message->message }}</p>
                                    <p class="text-xs mt-1 {{ $message->sender_id === auth()->id() ? 'text-gray-200 text-right' : 'text-gray-500' }}">
                                        {{ $message->created_at->format('M d, H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <form action="{{ route('chat.store', [$car->id, $otherUser->id]) }}" method="POST" class="mt-4 sticky bottom-0 bg-white z-10">
                        @csrf
                        <div class="flex gap-2">
                            <input type="text" name="message" 
                                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                   placeholder="Type your message..." required autocomplete="off">
                            <button type="submit" 
                                    class="bg-blue-600 text-white font-medium px-4 py-2 rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition flex items-center gap-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Send
                            </button>
                        </div>
                    </form>

                    <script>
                        // Scroll to bottom of chat messages
                        document.addEventListener('DOMContentLoaded', function() {
                            const chatMessages = document.getElementById('chat-messages');
                            chatMessages.scrollTop = chatMessages.scrollHeight;
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Add fade-in animation to messages
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