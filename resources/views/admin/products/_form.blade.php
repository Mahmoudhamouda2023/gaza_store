<div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name"
        value="{{ old('name', $product->name ?? '') }}" />
    @error('name')
        <small class="invalid-feedback">{{ $message }}</small>
    @enderror
</div>

<div class="row">
    <!-- Main Image -->
    <div class="col-md-6">
        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" onchange="showImg(event)"
                class="form-control @error('image') is-invalid @enderror" placeholder="Image" />
            @error('image')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
            @php
                $url = '';
                if (isset($product) && $product->image) {
                    $url = asset('images/' . $product->image->path);
                }
            @endphp
            <img width="80" id="preview" src="{{ $url }}" alt="">
        </div>
    </div>

    <!-- Gallery -->
    <div class="col-md-6">
        <div class="mb-3">
            <label>Gallery</label>
            <input type="file" name="gallery[]" multiple onchange="showImg(event)"
                class="form-control @error('gallery') is-invalid @enderror" placeholder="Gallery" />
            @error('gallery')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
            @php
                $galleryUrl = '';
                if (isset($product) && $product->gallery->isNotEmpty()) {
                    $galleryUrl = asset('images/' . $product->gallery->first()->path);
                }
            @endphp
            <img width="80" id="preview-gallery" src="{{ $galleryUrl }}" alt="">
        </div>
    </div>
</div>

<div class="row">
    <!-- Price -->
    <div class="col-md-4">
        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                placeholder="Price" value="{{ old('price', $product->price ?? '') }}" />
            @error('price')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <!-- Quantity -->
    <div class="col-md-4">
        <div class="mb-3">
            <label>Quantity</label>
            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
                placeholder="Quantity" value="{{ old('quantity', $product->quantity ?? '') }}" />
            @error('quantity')
                <small class="invalid-feedback">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <!-- Category -->
    <div class="col-md-4">
        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                <option value="">Select Category</option>
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
    <label>Description</label>
    <textarea name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Description"
        cols="30" rows="5">{{ old('description', $product->description ?? '') }}</textarea>
    @error('description')
        <small class="invalid-feedback">{{ $message }}</small>
    @enderror
</div>
