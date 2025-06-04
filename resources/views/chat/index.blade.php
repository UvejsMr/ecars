<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Conversations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($conversations->isEmpty())
                        <div class="flex flex-col items-center justify-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2h5" />
                            </svg>
                            <p class="text-gray-500 text-center mb-4">No conversations yet.</p>
                            <a href="/" class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Start Exploring Cars
                            </a>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($conversations as $key => $messages)
                                @php
                                    $firstMessage = $messages->first();
                                    $otherUser = $firstMessage->sender_id === auth()->id() 
                                        ? $firstMessage->receiver 
                                        : $firstMessage->sender;
                                    $unreadCount = $messages->where('receiver_id', auth()->id())
                                        ->where('is_read', false)
                                        ->count();
                                    $lastMessage = $messages->last();
                                    $isYou = $lastMessage->sender_id === auth()->id();
                                @endphp
                                <a href="{{ route('chat.show', [$firstMessage->car_id, $otherUser->id]) }}" 
                                   class="block p-4 bg-white rounded-2xl shadow hover:shadow-lg border transition group">
                                    <div class="flex items-center gap-4">
                                        <!-- Car Thumbnail -->
                                        @if($firstMessage->car->images->count() > 0)
                                            <img src="{{ Storage::url($firstMessage->car->images->first()->image_path) }}" alt="Car" class="w-14 h-14 rounded-lg object-cover border">
                                        @else
                                            <span class="w-14 h-14 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 text-2xl">🚗</span>
                                        @endif
                                        <!-- User Avatar -->
                                        <span class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xl border">{{ strtoupper(substr($otherUser->name, 0, 1)) }}</span>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex justify-between items-center">
                                                <h3 class="font-semibold truncate">{{ $firstMessage->car->make }} {{ $firstMessage->car->model }}</h3>
                                                @if($unreadCount > 0)
                                                    <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-bold animate-pulse shadow">{{ $unreadCount }}</span>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-sm text-gray-600 truncate">Chat with {{ $otherUser->name }}</span>
                                            </div>
                                            <p class="text-sm text-gray-500 mt-2 truncate">
                                                <span class="font-semibold">{{ $isYou ? 'You:' : $otherUser->name . ':' }}</span>
                                                {{ Str::limit($lastMessage->message, 50) }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 