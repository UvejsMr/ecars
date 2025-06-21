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

                    <!-- Chat Messages Container -->
                    <div class="space-y-4 mb-6 h-[500px] overflow-y-auto px-4 fade-in" id="chat-messages">
                        @foreach($messages as $message)
                            <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }} items-end gap-2 message-item" data-message-id="{{ $message->id }}">
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

                    <!-- Typing Indicator -->
                    <div id="typing-indicator" class="hidden mb-4 px-4">
                        <div class="flex items-center gap-2">
                            <div class="bg-gray-100 text-gray-800 rounded-2xl px-4 py-2 shadow-md">
                                <div class="flex space-x-1">
                                    <div class="w-2 h-2 bg-gray-400 rounded-full typing-dot"></div>
                                    <div class="w-2 h-2 bg-gray-400 rounded-full typing-dot"></div>
                                    <div class="w-2 h-2 bg-gray-400 rounded-full typing-dot"></div>
                                    <div class="w-2 h-2 bg-gray-400 rounded-full typing-dot"></div>
                                    <div class="w-2 h-2 bg-gray-400 rounded-full typing-dot"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Message Input Form -->
                    <form id="chat-form" class="mt-4 sticky bottom-0 bg-white z-10">
                        @csrf
                        <div class="flex gap-2">
                            <input type="text" name="message" id="message-input"
                                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                   placeholder="Type your message..." required autocomplete="off" maxlength="1000"
                                   aria-label="Type your message">
                            <button type="submit" id="send-button"
                                    class="bg-blue-600 text-white font-medium px-4 py-2 rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition flex items-center gap-1 disabled:opacity-50 disabled:cursor-not-allowed"
                                    aria-label="Send message"
                                    title="Send message">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span id="send-text">Send</span>
                            </button>
                        </div>
                        <div class="text-xs text-gray-500 mt-1 text-right">
                            <span id="char-count">0</span>/1000
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Prevent multiple initializations
        if (window.chatInitialized) {
            console.log('Chat already initialized, skipping...');
        } else {
            window.chatInitialized = true;
            
            // Chat functionality
            document.addEventListener('DOMContentLoaded', function() {
                const chatMessages = document.getElementById('chat-messages');
                const chatForm = document.getElementById('chat-form');
                const messageInput = document.getElementById('message-input');
                const sendButton = document.getElementById('send-button');
                const sendText = document.getElementById('send-text');
                const charCount = document.getElementById('char-count');
                const typingIndicator = document.getElementById('typing-indicator');
                
                let lastMessageId = {{ $messages->count() > 0 ? $messages->last()->id : 0 }};
                let pollingInterval;
                let isSubmitting = false; // Flag to prevent double submission

                // Scroll to bottom of chat messages
                function scrollToBottom() {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }

                // Add fade-in animation to messages
                function addFadeInAnimation(element) {
                    element.classList.add('message-fade-in');
                }

                // Add a new message to the chat
                function addMessageToChat(messageData, isNewMessage = true) {
                    const isOwnMessage = messageData.sender_id === {{ auth()->id() }};
                    const otherUserName = '{{ $otherUser->name }}';
                    
                    const messageHtml = `
                        <div class="flex ${isOwnMessage ? 'justify-end' : 'justify-start'} items-end gap-2 message-item" data-message-id="${messageData.id}">
                            ${!isOwnMessage ? `<span class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm border">${otherUserName.charAt(0).toUpperCase()}</span>` : ''}
                            <div class="max-w-[70%] ${isOwnMessage ? 'bg-blue-600 text-white ml-auto' : 'bg-gray-100 text-gray-800'} rounded-2xl px-4 py-2 shadow-md relative">
                                <p>${escapeHtml(messageData.message)}</p>
                                <p class="text-xs mt-1 ${isOwnMessage ? 'text-gray-200 text-right' : 'text-gray-500'}">
                                    ${messageData.created_at}
                                </p>
                            </div>
                        </div>
                    `;
                    
                    const messageElement = document.createElement('div');
                    messageElement.innerHTML = messageHtml;
                    const messageDiv = messageElement.firstElementChild;
                    
                    chatMessages.appendChild(messageDiv);
                    
                    if (isNewMessage) {
                        addFadeInAnimation(messageDiv);
                        scrollToBottom();
                    }
                    
                    lastMessageId = Math.max(lastMessageId, messageData.id);
                }

                // Escape HTML to prevent XSS
                function escapeHtml(text) {
                    const div = document.createElement('div');
                    div.textContent = text;
                    return div.innerHTML;
                }

                // Character count
                messageInput.addEventListener('input', function() {
                    const count = this.value.length;
                    charCount.textContent = count;
                    
                    if (count > 900) {
                        charCount.classList.add('text-red-500');
                    } else {
                        charCount.classList.remove('text-red-500');
                    }
                });

                // Handle form submission
                chatForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Prevent double submission
                    if (isSubmitting) {
                        console.log('Already submitting, ignoring duplicate submission');
                        return;
                    }
                    
                    const message = messageInput.value.trim();
                    if (!message) return;
                    
                    // Set submission flag
                    isSubmitting = true;
                    
                    // Disable form while sending
                    sendButton.disabled = true;
                    sendText.textContent = 'Sending...';
                    messageInput.disabled = true;
                    
                    // Send message via AJAX
                    fetch('{{ route("chat.store", [$car->id, $otherUser->id]) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ message: message })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => {
                                throw new Error(`HTTP error! status: ${response.status}, body: ${text}`);
                            });
                        }
                        
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Add message to chat immediately
                            addMessageToChat(data.message, true);
                            
                            // Clear input
                            messageInput.value = '';
                            charCount.textContent = '0';
                            
                            // Hide typing indicator if it was shown
                            typingIndicator.classList.add('hidden');
                        } else {
                            console.error('Server returned error:', data);
                            alert('Error sending message: ' + (data.message || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                        alert('Error sending message: ' + error.message);
                    })
                    .finally(() => {
                        // Reset submission flag
                        isSubmitting = false;
                        
                        // Re-enable form
                        sendButton.disabled = false;
                        sendText.textContent = 'Send';
                        messageInput.disabled = false;
                        messageInput.focus();
                    });
                });

                // Poll for new messages
                function pollForNewMessages() {
                    fetch(`{{ route('chat.messages', [$car->id, $otherUser->id]) }}?last_message_id=${lastMessageId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.messages.length > 0) {
                            data.messages.forEach(message => {
                                // Only add messages from the other user (not our own)
                                if (message.sender_id !== {{ auth()->id() }}) {
                                    addMessageToChat(message, true);
                                }
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error polling for messages:', error);
                    });
                }

                // Start polling for new messages
                pollingInterval = setInterval(pollForNewMessages, 3000); // Poll every 3 seconds

                // Clean up on page unload
                window.addEventListener('beforeunload', function() {
                    clearInterval(pollingInterval);
                });

                // Initial scroll to bottom
                scrollToBottom();
                
                // Add fade-in animation to existing messages
                const fadeEls = document.querySelectorAll('.fade-in');
                fadeEls.forEach((el, index) => {
                    setTimeout(() => {
                        el.classList.add('fade-in-animation');
                    }, index * 100);
                });
            });
        }
    </script>
    @endpush
</x-app-layout> 