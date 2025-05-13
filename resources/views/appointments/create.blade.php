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
                        </div>

                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700">Select Time</label>
                            <select name="start_time" id="start_time" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                <option value="">Select a time slot</option>
                                <option value="08:00">8:00 AM</option>
                                <option value="09:00">9:00 AM</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="12:00">12:00 PM</option>
                                <option value="13:00">1:00 PM</option>
                                <option value="14:00">2:00 PM</option>
                                <option value="15:00">3:00 PM</option>
                                <option value="16:00">4:00 PM</option>
                            </select>
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
            const userId = '{{ $servicer->user_id }}';
            
            // Clear existing options
            timeSelect.innerHTML = '<option value="">Select a time slot</option>';
            
            if (date) {
                console.log('Fetching slots for date:', date, 'userId:', userId);
                
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
                    if (!Array.isArray(slots) || slots.length === 0) {
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'No available slots for this date';
                        timeSelect.appendChild(option);
                    } else {
                        slots.forEach(slot => {
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
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'Error loading time slots: ' + error.message;
                    timeSelect.appendChild(option);
                });
            }
        });
    </script>
    @endpush
</x-app-layout> 