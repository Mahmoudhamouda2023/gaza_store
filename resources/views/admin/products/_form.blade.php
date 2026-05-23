<div class="mb-3">
    <label>{{ __('admin.name') }}</label>

    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
        placeholder="{{ __('admin.name') }}" value="{{ old('name', $product->name ?? '') }}" />

    @error('name')
        <small class="invalid-feedback">{{ $message }}</small>
    @enderror
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label>{{ __('admin.image') }}</label>

            <input type="file" name="image" onchange="showImg(event)"
                class="form-control @error('image') is-invalid @enderror" />

            @error('image')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror

            @php
                $url = '';
                if (isset($product) && $product->image) {
                    $url = asset('images/' . $product->image->path);
                }
            @endphp

            <img width="80" id="preview" src="{{ $url }}" alt="{{ __('admin.image_preview') }}"
                class="mt-2">
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label>{{ __('admin.gallery') }}</label>

            <input type="file" name="gallery[]" multiple onchange="showImg(event)"
                class="form-control @error('gallery') is-invalid @enderror" />

            @error('gallery')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror

            @php
                $galleryUrl = '';
                if (isset($product) && $product->exists) {
                    $firstGalleryImage = $product->gallery->first();
                    if ($firstGalleryImage) {
                        $galleryUrl = asset('images/' . $firstGalleryImage->path);
                    }
                }
            @endphp

            <img width="80" id="galleryPreview" src="{{ $galleryUrl }}" alt="{{ __('admin.gallery_preview') }}"
                class="mt-2">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            <label>{{ __('admin.price') }}</label>

            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                placeholder="{{ __('admin.price') }}" value="{{ old('price', $product->price ?? '') }}" />

            @error('price')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label>{{ __('admin.quantity') }}</label>

            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
                placeholder="{{ __('admin.quantity') }}" value="{{ old('quantity', $product->quantity ?? '') }}" />

            @error('quantity')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label>{{ __('admin.category') }}</label>

            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">

                <option value="">{{ __('admin.select_category') }}</option>

                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}"
                        {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            @error('category_id')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>

<div class="mb-3">
    <label>{{ __('admin.description') }}</label>

    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
        placeholder="{{ __('admin.description') }}" cols="30" rows="5">{{ old('description', $product->description ?? '') }}</textarea>

    @error('description')
        <small class="invalid-feedback">{{ $message }}</small>
    @enderror
</div>
