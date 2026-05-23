@extends('admin.master')

@section('title', __('admin.edit_role'))

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                {{ __('admin.edit_role') }}
            </h1>

            <p class="text-muted mb-0">
                {{ __('admin.update_role_permissions') }}
            </p>
        </div>

        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>
            {{ __('admin.back') }}
        </a>
    </div>

    <div class="card shadow border-0 mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ __('admin.role_information') }}
            </h6>
        </div>

        <div class="card-body">
            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="font-weight-bold">
                        {{ __('admin.role_name') }}
                    </label>

                    <input type="text" class="form-control" value="{{ ucfirst($role->name) }}" disabled>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="font-weight-bold">
                        {{ __('admin.guard') }}
                    </label>

                    <input type="text" class="form-control" value="{{ $role->guard_name }}" disabled>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="font-weight-bold">
                        {{ __('admin.created_at') }}
                    </label>

                    <input type="text" class="form-control"
                        value="{{ $role->created_at ? $role->created_at->format('d M Y - h:i A') : '-' }}" disabled>
                </div>

            </div>
        </div>
    </div>

    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card shadow border-0">

            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{ __('admin.role_permissions') }}
                    </h6>

                    <small class="text-muted">
                        {{ __('admin.role_permissions_description') }}
                    </small>
                </div>

                <button type="button" class="btn btn-sm btn-outline-primary" onclick="toggleAllPermissions()">

                    {{ __('admin.select_unselect_all') }}
                </button>
            </div>

            <div class="card-body">

                @error('permissions')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror

                @forelse ($permissions as $group => $groupPermissions)

                    <div class="permission-group mb-4">

                        <div
                            class="d-flex justify-content-between align-items-center bg-light border rounded px-3 py-2 mb-3">

                            <h6 class="mb-0 text-primary font-weight-bold">
                                {{ ucfirst($group) }}
                            </h6>

                            <button type="button" class="btn btn-sm btn-light border"
                                onclick="toggleGroupPermissions('{{ Str::slug($group) }}')">

                                {{ __('admin.toggle_group') }}
                            </button>

                        </div>

                        <div class="row">

                            @foreach ($groupPermissions as $permission)
                                <div class="col-md-4 col-lg-3 mb-3 permission-item group-{{ Str::slug($group) }}">

                                    <label class="border rounded p-3 w-100 h-100 mb-0 permission-box">

                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                            class="mr-2 permission-checkbox"
                                            {{ in_array($permission->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}>

                                        <span>{{ $permission->name }}</span>

                                    </label>

                                </div>
                            @endforeach

                        </div>

                    </div>

                @empty

                    <div class="text-center text-muted py-5">
                        {{ __('admin.no_permissions_found') }}
                    </div>

                @endforelse

            </div>

            <div class="card-footer bg-white d-flex justify-content-between align-items-center">

                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                    {{ __('admin.cancel') }}
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i>
                    {{ __('admin.update_permissions') }}
                </button>

            </div>

        </div>
    </form>

    <style>
        .permission-box {
            cursor: pointer;
            transition: 0.2s ease;
            background: #fff;
        }

        .permission-box:hover {
            border-color: #4e73df !important;
            background: #f8f9fc;
        }

        .permission-checkbox {
            transform: scale(1.1);
        }
    </style>

    <script>
        function toggleAllPermissions() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);

            checkboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
            });
        }

        function toggleGroupPermissions(groupClass) {
            const checkboxes = document.querySelectorAll('.group-' + groupClass + ' .permission-checkbox');
            const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);

            checkboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
            });
        }
    </script>

@endsection
