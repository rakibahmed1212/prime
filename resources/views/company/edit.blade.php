<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Company') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <form method="POST" action="{{ route('companies.update', $company) }}">
            @csrf
            @method('PUT')
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                    value="{{ old('name', $company->name) }}" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Address -->
            <div class="mt-4">
                <x-input-label for="address" :value="__('Address')" />
                <textarea id="address"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    name="address" required autocomplete="address">{{ old('address', $company->address) }}</textarea>
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <label for="facility">Facility:</label>
            <div id="facility-values">
                @foreach ($company->facilities as $index => $facility)
                    <div>
                        <input type="text" name="facility_type[]"
                            value="{{ old('facility_type.' . $index, $facility->facility_type) }}" required>
                        <input type="text" name="facility_value[]"
                            value="{{ old('facility_value.' . $index, $facility->facility_value) }}" required>
                        </br></br>
                    </div>
                @endforeach
            </div>

            <button type="button" id="add-more">Add More</button>
            <br><br>
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-4">
                    {{ __('Update') }}
                </x-primary-button>
            </div>
        </form>
    </div>
    <script>
        let count = {{ $company->facilities->count() }};
        document.getElementById('add-more').addEventListener('click', function() {
            count++;
            const div = document.createElement('div');
            div.innerHTML =
                `<div><input type="text" name="facility_type[]" id="facility_type_${count}" required>
                             <input type="text" name="facility_value[]" id="facility_value_${count}" required></br></br></div>`;
            document.getElementById('facility-values').appendChild(div);
        });
    </script>
</x-app-layout>
