<div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name"
        value="{{ old('name', $category->name ?? '') }}" />
    @error('name')
        <small class="invalid-feedback">{{ $message }}</small>
    @enderror
</div>

<div class="mb-3">
    <label>Image</label>
    <input type="file" name="image" onchange="showImg(event)"
        class="form-control @error('image') is-invalid @enderror" placeholder="Image" />
    @error('image')
        <small class="invalid-feedback">{{ $message }}</small>
    @enderror
    @php
        $url = '';
        if ($category->image) {
            $url = $category->img_path;
        }
    @endphp

    <img width="80" id="preview" src="{{ $url }}" alt="">
</div>

<div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Description"
        cols="30" rows="5">{{ old('description', $category->description ?? '') }}</textarea>
    @error('description')
        <small class="invalid-feedback">{{ $message }}</small>
    @enderror
</div>
