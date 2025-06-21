<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Oops!</strong>
                <ul class="mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Book Inspection with {{ $servicer->company_name }}</h3>
                        <p class="text-gray-600">For your {{ $car->make }} {{ $car->model }}</p>
                    </div>

                    <form action="{{ route('appointments.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $servicer->user_id }}">
                        <input type="hidden" name="car_id" value="{{ $car->id }}">

                        <div>
                            <label for="appointment_date" class="block text-sm font-medium text-gray-700">Select Date</label>
                            <input type="date" name="appointment_date" id="appointment_date" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   min="{{ date('Y-m-d') }}" required value="{{ old('appointment_date') }}">
                            <div id="selected-date-display" class="hidden mt-2 text-sm text-gray-600 font-medium"></div>
                        </div>

                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700">Select Time</label>
                            <select name="start_time" id="start_time" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required disabled>
                                <option value="">Select a date first</option>
                            </select>
                            <div id="loading-slots" class="hidden mt-2 text-sm text-blue-600">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Loading available time slots...
                            </div>
                            <div id="slots-info" class="hidden mt-2 text-sm text-green-600 bg-green-50 p-2 rounded-md">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span id="slots-count">0</span> time slots available
                            </div>
                            <div id="no-slots-message" class="hidden mt-2 text-sm text-amber-600 bg-amber-50 p-2 rounded-md">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                                No available time slots for this date. Please select another date.
                            </div>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                            <textarea name="notes" id="notes" rows="3" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                      placeholder="Any specific concerns or details you'd like to mention?">{{ old('notes') }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-500 text-black rounded-md hover:bg-blue-600">
                                Book Appointment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('appointment_date').addEventListener('change', function() {
            const date = this.value;
            const timeSelect = document.getElementById('start_time');
            const loadingDiv = document.getElementById('loading-slots');
            const noSlotsDiv = document.getElementById('no-slots-message');
            const slotsInfoDiv = document.getElementById('slots-info');
            const slotsCountSpan = document.getElementById('slots-count');
            const selectedDateDisplay = document.getElementById('selected-date-display');
            const userId = '{{ $servicer->user_id }}';
            
            // Reset UI states
            timeSelect.disabled = true;
            timeSelect.innerHTML = '<option value="">Select a date first</option>';
            loadingDiv.classList.add('hidden');
            noSlotsDiv.classList.add('hidden');
            slotsInfoDiv.classList.add('hidden');
            selectedDateDisplay.classList.add('hidden');
            
            if (date) {
                console.log('Fetching slots for date:', date, 'userId:', userId);
                
                // Show selected date
                const dateObj = new Date(date);
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                selectedDateDisplay.textContent = `Selected: ${dateObj.toLocaleDateString('en-US', options)}`;
                selectedDateDisplay.classList.remove('hidden');
                
                // Show loading state
                loadingDiv.classList.remove('hidden');
                
                // Fetch available time slots
                const url = `{{ route('appointments.slots', ['userId' => $servicer->user_id]) }}?date=${date}`;
                console.log('Fetching from URL:', url);
                
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(slots => {
                    console.log('Received slots:', slots);
                    console.log('Slots type:', typeof slots);
                    console.log('Slots length:', slots.length);
                    console.log('Is array:', Array.isArray(slots));
                    
                    // Hide loading state
                    loadingDiv.classList.add('hidden');
                    
                    if (!Array.isArray(slots) || slots.length === 0) {
                        console.log('No slots available or invalid response');
                        // Show no slots message
                        noSlotsDiv.classList.remove('hidden');
                        timeSelect.innerHTML = '<option value="">No available slots</option>';
                    } else {
                        console.log('Processing available slots:', slots);
                        // Enable select and populate with available slots
                        timeSelect.disabled = false;
                        timeSelect.innerHTML = '<option value="">Select a time slot</option>';
                        
                        // Show slots info
                        slotsCountSpan.textContent = slots.length;
                        slotsInfoDiv.classList.remove('hidden');
                        
                        slots.forEach(slot => {
                            console.log('Adding slot:', slot);
                            const option = document.createElement('option');
                            option.value = slot;
                            // Convert 24-hour format to 12-hour format with AM/PM
                            const [hours, minutes] = slot.split(':');
                            const hour = parseInt(hours);
                            const ampm = hour >= 12 ? 'PM' : 'AM';
                            const hour12 = hour % 12 || 12;
                            option.textContent = `${hour12}:${minutes} ${ampm}`;
                            timeSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching time slots:', error);
                    
                    // Hide loading state
                    loadingDiv.classList.add('hidden');
                    
                    // Show error message
                    timeSelect.innerHTML = '<option value="">Error loading time slots</option>';
                    
                    // Show error notification
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'mt-2 text-sm text-red-600 bg-red-50 p-2 rounded-md';
                    errorDiv.innerHTML = `
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Error loading time slots. Please try again.
                    `;
                    
                    // Remove any existing error message
                    const existingError = timeSelect.parentNode.querySelector('.text-red-600');
                    if (existingError) {
                        existingError.remove();
                    }
                    
                    timeSelect.parentNode.appendChild(errorDiv);
                });
            }
        });
    </script>
    @endpush
</x-app-layout> 