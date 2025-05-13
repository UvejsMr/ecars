<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Chat about {{ $car->make }} {{ $car->model }}
            </h2>
            <a href="{{ route('chat.index') }}" class="text-blue-500 hover:text-blue-700">
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

                    <div class="space-y-4 mb-6 h-[500px] overflow-y-auto px-4" id="chat-messages">
                        @foreach($messages as $message)
                            <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[70%] {{ $message->sender_id === auth()->id() ? 'bg-blue-500 text-black' : 'bg-gray-100 text-gray-800' }} rounded-lg px-4 py-2">
                                    <p>{{ $message->message }}</p>
                                    <p class="text-xs {{ $message->sender_id === auth()->id() ? 'text-gray-700' : 'text-gray-500' }} mt-1">
                                        {{ $message->created_at->format('M d, H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <form action="{{ route('chat.store', [$car->id, $otherUser->id]) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="flex gap-2">
                            <input type="text" name="message" 
                                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                   placeholder="Type your message..." required>
                            <button type="submit" 
                                    class="bg-blue-500 text-black font-medium px-4 py-2 rounded-md hover:bg-blue-600 transition">
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
</x-app-layout> 