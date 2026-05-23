<div class="mb-3">
    <label>{{ __('admin.name') }}</label>

    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
        placeholder="{{ __('admin.name') }}" value="{{ old('name', $category->name ?? '') }}" />

    @error('name')
        <small class="invalid-feedback">{{ $message }}</small>
    @enderror
</div>

<div class="mb-3">
    <label>{{ __('admin.image') }}</label>

    <input type="file" name="image" onchange="showImg(event)"
        class="form-control @error('image') is-invalid @enderror" />

    @error('image')
        <small class="invalid-feedback">{{ $message }}</small>
    @enderror

    @php
        $url = '';

        if (isset($category) && $category->image) {
            $url = $category->img_path;
        }
    @endphp

    <img width="80" id="preview" src="{{ $url }}" alt="{{ __('admin.image_preview') }}" class="mt-2">
</div>

<div class="mb-3">
    <label>{{ __('admin.description') }}</label>

    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
        placeholder="{{ __('admin.description') }}" cols="30" rows="5">{{ old('description', $category->description ?? '') }}</textarea>

    @error('description')
        <small class="invalid-feedback">{{ $message }}</small>
    @enderror
</div>
