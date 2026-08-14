<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Property Code</label>
        <input type="text"
               name="code"
               class="form-control"
               value="{{ old('code', $property->code ?? '') }}"
               required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Property Name</label>
        <input type="text"
               name="name"
               class="form-control"
               value="{{ old('name', $property->name ?? '') }}"
               required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Property Type</label>

        <select name="type" class="form-select">

            @foreach([
                'Apartment',
                'Bedsitter',
                'Commercial',
                'Office',
                'Maisonette',
                'Hostel',
                'Mixed Use',
                'Other'
            ] as $type)

                <option value="{{ $type }}"
                    @selected(old('type', $property->type ?? '') == $type)>
                    {{ $type }}
                </option>

            @endforeach

        </select>

    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">County</label>
        <input type="text"
               name="county"
               class="form-control"
               value="{{ old('county', $property->county ?? '') }}"
               required>
    </div>

    @if(isset($clients) && $clients->isNotEmpty())
        <div class="col-md-6 mb-3">
            <label class="form-label">Property client / owner</label>
            <select name="property_client_id" class="form-select">
                <option value="">Managed directly by this organization</option>
                @foreach($clients as $client)<option value="{{ $client->id }}" @selected(old('property_client_id', $property->property_client_id ?? '') == $client->id)>{{ $client->name }}</option>@endforeach
            </select>
        </div>
    @endif

    <div class="col-md-6 mb-3">
        <label class="form-label">Town</label>
        <input type="text"
               name="town"
               class="form-control"
               value="{{ old('town', $property->town ?? '') }}"
               required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Address</label>
        <input type="text"
               name="address"
               class="form-control"
               value="{{ old('address', $property->address ?? '') }}"
               required>
    </div>

    <div class="col-12 mb-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <label class="form-label mb-0">Verified property location</label>
                <small class="d-block text-secondary">Search or click the map to pin the actual property location. Coordinates are required.</small>
            </div>
            <button class="btn btn-sm btn-outline-primary" id="useMyLocation" type="button"><i class="bi bi-crosshair"></i> Use my location</button>
        </div>
        <div class="row g-2 mb-2">
            <div class="col-md-6"><div class="input-group"><input class="form-control" type="search" id="locationSearch" placeholder="Search a place, estate, road, or landmark"><button class="btn btn-outline-primary" id="searchLocation" type="button">Search</button></div></div>
            <div class="col-md-6"><div class="input-group"><input class="form-control" type="url" id="googleMapsLink" placeholder="Paste a Google Maps shared link or coordinates"><button class="btn btn-outline-secondary" id="useGoogleMapsLink" type="button">Use link</button></div></div>
        </div>
        <div id="locationSearchResults" class="list-group mb-2 d-none"></div>
        <div id="propertyLocationMap" class="property-location-map" aria-label="Property location map"></div>
        <div class="row g-3 mt-1">
            <div class="col-md-6">
                <label class="form-label" for="latitude">Latitude</label>
                <input type="number" step="0.0000001" min="-90" max="90" id="latitude" name="latitude" class="form-control @error('latitude') is-invalid @enderror" value="{{ old('latitude', $property->latitude ?? '') }}" required>
                @error('latitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label" for="longitude">Longitude</label>
                <input type="number" step="0.0000001" min="-180" max="180" id="longitude" name="longitude" class="form-control @error('longitude') is-invalid @enderror" value="{{ old('longitude', $property->longitude ?? '') }}" required>
                @error('longitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Floors</label>
        <input type="number"
               name="floors"
               class="form-control"
               value="{{ old('floors', $property->floors ?? 1) }}"
               min="1">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Status</label>

        <select name="status" class="form-select">

            <option value="Active"
                @selected(old('status', $property->status ?? '') == 'Active')>
                Active
            </option>

            <option value="Inactive"
                @selected(old('status', $property->status ?? '') == 'Inactive')>
                Inactive
            </option>

        </select>

    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Description</label>

        <textarea name="description"
                  class="form-control"
                  rows="4">{{ old('description', $property->description ?? '') }}</textarea>
    </div>

    <div class="col-12 mb-3">
        <label class="form-label">Tenant-attracting amenities</label>
        <p class="small text-secondary mb-2">Select everything the property offers. These can later help tenants filter their search.</p>
        @php($selectedAmenities = old('amenities', $property->amenities ?? []))
        <div class="row g-2">
            @foreach(['Smart water meter', 'Reliable internet', 'Biometric access', 'CCTV surveillance', 'Electricity backup', 'Lift / elevator', 'Security guards', 'Gated compound', 'Parking', 'Borehole water', 'Solar power', 'Garbage collection'] as $amenity)
                <div class="col-sm-6 col-lg-4"><label class="form-check border rounded p-2 h-100"><input class="form-check-input me-2" type="checkbox" name="amenities[]" value="{{ $amenity }}" @checked(in_array($amenity, $selectedAmenities))>{{ $amenity }}</label></div>
            @endforeach
        </div>
    </div>

    <div class="col-12 mb-3">
        <label class="form-label">Verification evidence and property media</label>
        <p class="small text-secondary">Upload clear files to help our team verify the property. Images and PDFs are accepted; each file can be up to 10 MB.</p>
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label small">Exterior photos</label><input class="form-control" type="file" name="exterior_photos[]" accept="image/*" multiple></div>
            <div class="col-md-6"><label class="form-label small">Interior photos</label><input class="form-control" type="file" name="interior_photos[]" accept="image/*" multiple></div>
            <div class="col-md-6"><label class="form-label small">Location / landmark photos</label><input class="form-control" type="file" name="location_photos[]" accept="image/*" multiple></div>
            <div class="col-md-6"><label class="form-label small">Title, management, or authorization documents</label><input class="form-control" type="file" name="verification_documents[]" accept=".pdf,image/*" multiple></div>
        </div>
        @foreach(['exterior_photos', 'interior_photos', 'location_photos', 'verification_documents'] as $uploadField)
            @error($uploadField)<div class="text-danger small mt-2">{{ $message }}</div>@enderror
            @error($uploadField.'.*')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
        @endforeach
    </div>

</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const latitude = document.getElementById('latitude');
    const longitude = document.getElementById('longitude');
    const initialLat = parseFloat(latitude.value) || -1.286389;
    const initialLng = parseFloat(longitude.value) || 36.817223;
    const map = L.map('propertyLocationMap').setView([initialLat, initialLng], latitude.value && longitude.value ? 16 : 6);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap contributors' }).addTo(map);
    let marker;
    const setCoordinates = (lat, lng, zoom = true) => {
        latitude.value = Number(lat).toFixed(7);
        longitude.value = Number(lng).toFixed(7);
        marker ? marker.setLatLng([lat, lng]) : marker = L.marker([lat, lng], { draggable: true }).addTo(map);
        marker.on('dragend', () => setCoordinates(marker.getLatLng().lat, marker.getLatLng().lng, false));
        if (zoom) map.setView([lat, lng], 16);
    };
    if (latitude.value && longitude.value) setCoordinates(initialLat, initialLng, false);
    map.on('click', event => setCoordinates(event.latlng.lat, event.latlng.lng));
    document.getElementById('useMyLocation').addEventListener('click', () => navigator.geolocation?.getCurrentPosition(
        position => setCoordinates(position.coords.latitude, position.coords.longitude),
        () => alert('We could not access your location. Please click the property on the map instead.')
    ));
    [latitude, longitude].forEach(input => input.addEventListener('change', () => {
        if (latitude.value && longitude.value) setCoordinates(parseFloat(latitude.value), parseFloat(longitude.value));
    }));
    const results = document.getElementById('locationSearchResults');
    const runSearch = async () => {
        const query = document.getElementById('locationSearch').value.trim();
        if (!query) return;
        results.innerHTML = '<span class="list-group-item">Searching location…</span>';
        results.classList.remove('d-none');
        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/search?format=jsonv2&limit=5&countrycodes=ke&q=${encodeURIComponent(query)}`);
            const places = await response.json();
            results.innerHTML = places.length ? '' : '<span class="list-group-item">No locations found. Try a nearby landmark.</span>';
            places.forEach(place => { const button = document.createElement('button'); button.type = 'button'; button.className = 'list-group-item list-group-item-action'; button.textContent = place.display_name; button.addEventListener('click', () => { setCoordinates(place.lat, place.lon); results.classList.add('d-none'); }); results.append(button); });
        } catch { results.innerHTML = '<span class="list-group-item text-danger">Search is unavailable. Paste a Google Maps link or choose on the map.</span>'; }
    };
    document.getElementById('searchLocation').addEventListener('click', runSearch);
    document.getElementById('locationSearch').addEventListener('keydown', event => { if (event.key === 'Enter') { event.preventDefault(); runSearch(); } });
    document.getElementById('useGoogleMapsLink').addEventListener('click', () => {
        const link = decodeURIComponent(document.getElementById('googleMapsLink').value);
        const match = link.match(/@(-?\d+(?:\.\d+)?),(-?\d+(?:\.\d+)?)/) || link.match(/[?&](?:q|query)=(-?\d+(?:\.\d+)?),(-?\d+(?:\.\d+)?)/) || link.match(/(-?\d+\.\d+),\s*(-?\d+\.\d+)/);
        if (match) setCoordinates(match[1], match[2]); else alert('We could not find coordinates in that link. Open Google Maps, share the place link, then paste it here.');
    });
});
</script>
