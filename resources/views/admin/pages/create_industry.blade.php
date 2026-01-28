@extends('admin.master_layout.index')
@section('page-title', 'Create Industry')
@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Create New Industry</h1>
                <p class="text-gray-600 mt-1">Add a new industry to the system</p>
            </div>
            <a href="{{ route('admin.industries') }}"
                class="bg-gray-500 text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors">
                <i class="bi bi-arrow-left mr-1"></i> Back to Industries
            </a>
        </div>
    </div>

    <!-- Create Form -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('admin.industries.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-building mr-1"></i> Industry Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter Industry Name" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('name') border-red-500 @enderror" />
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-person mr-1"></i> Contact Person
                    </label>
                    <input type="text" name="contact_person" value="{{ old('contact_person') }}" placeholder="Enter Contact Person Name"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('contact_person') border-red-500 @enderror" />
                    @error('contact_person')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-envelope mr-1"></i> Email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter Email"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('email') border-red-500 @enderror" />
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-phone mr-1"></i> Phone
                    </label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Enter Phone Number"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('phone') border-red-500 @enderror" />
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-globe mr-1"></i> Website
                    </label>
                    <input type="url" name="website" value="{{ old('website') }}" placeholder="https://example.com"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('website') border-red-500 @enderror" />
                    @error('website')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-geo-alt mr-1"></i> Address
                    </label>
                    <input type="text" name="address" id="addressInput" value="{{ old('address') }}" placeholder="Start typing address..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('address') border-red-500 @enderror" />
                    <input type="hidden" name="latitude" id="latitudeInput" value="{{ old('latitude') }}">
                    <input type="hidden" name="longitude" id="longitudeInput" value="{{ old('longitude') }}">
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-file-text mr-1"></i> Description
                </label>
                <textarea name="description" rows="4" placeholder="Enter Industry Description"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-4 border-t">
                <button type="submit"
                    class="bg-brand text-white text-sm px-4 py-2 rounded-md hover:bg-gold transition-colors font-medium">
                     Create Industry
                </button>
                <a href="{{ route('admin.industries') }}"
                    class="bg-gray-500 text-white text-sm px-4 py-2 rounded-md hover:bg-gray-600 transition-colors font-medium">
                     Cancel
                </a>
            </div>
        </form>
    </div>
@endsection

<!-- Google Maps API -->
<script>
    function initAutocomplete() {
        if (typeof google === 'undefined' || !google.maps || !google.maps.places) {
            return;
        }

        const addressInput = document.getElementById('addressInput');
        const latInput = document.getElementById('latitudeInput');
        const lngInput = document.getElementById('longitudeInput');

        if (addressInput && latInput && lngInput) {
            const autocomplete = new google.maps.places.Autocomplete(addressInput, {
                componentRestrictions: { country: 'au' }
            });

            autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();
                if (place.geometry) {
                    latInput.value = place.geometry.location.lat();
                    lngInput.value = place.geometry.location.lng();
                }
            });
        }
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB92zhVRCzKP_yXXFAko45mb6y1OAH_qgs&libraries=places&callback=initAutocomplete" async defer></script>
