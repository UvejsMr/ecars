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
                        <p class="text-center text-gray-500">No conversations yet.</p>
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
                                @endphp
                                <a href="{{ route('chat.show', [$firstMessage->car_id, $otherUser->id]) }}" 
                                   class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h3 class="font-semibold">{{ $firstMessage->car->make }} {{ $firstMessage->car->model }}</h3>
                                            <p class="text-sm text-gray-600">Chat with {{ $otherUser->name }}</p>
                                        </div>
                                        @if($unreadCount > 0)
                                            <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-sm">
                                                {{ $unreadCount }}
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-500 mt-2">
                                        {{ Str::limit($firstMessage->message, 50) }}
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 