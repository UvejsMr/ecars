<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Start a Conversation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">About {{ $car->make }} {{ $car->model }}</h3>
                        <p class="text-gray-600">You're about to start a conversation with the seller of this car.</p>
                    </div>

                    <form action="{{ route('chat.store', [$car->id, $car->user_id]) }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700">Your Message</label>
                                <textarea name="message" id="message" rows="4" 
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                          placeholder="Write your message to the seller..." required></textarea>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" 
                                        class="bg-blue-500 text-black font-medium px-4 py-2 rounded-md hover:bg-blue-600 transition">
                                    Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 