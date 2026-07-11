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

</div>