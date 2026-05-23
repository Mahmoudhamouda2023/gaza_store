@extends('admin.master')

@section('title', __('admin.view_role'))

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                {{ __('admin.view_role') }}
            </h1>

            <p class="text-muted mb-0">
                {{ __('admin.role_details_permissions') }}
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
                    <label class="font-weight-bold">{{ __('admin.role_name') }}</label>

                    <div>
                        <span class="badge badge-primary px-3 py-2">
                            {{ ucfirst($role->name) }}
                        </span>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="font-weight-bold">{{ __('admin.guard') }}</label>

                    <div>
                        <span class="badge badge-dark px-3 py-2">
                            {{ $role->guard_name }}
                        </span>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="font-weight-bold">{{ __('admin.created_at') }}</label>

                    <p class="mb-0">
                        {{ $role->created_at ? $role->created_at->format('d M Y - h:i A') : '-' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ __('admin.assigned_permissions') }}
            </h6>

            <span class="badge badge-info px-3 py-2">
                {{ $role->permissions->count() }} {{ __('admin.permissions') }}
            </span>
        </div>

        <div class="card-body">
            @if ($role->permissions->count())
                <div class="row">
                    @foreach ($role->permissions as $permission)
                        <div class="col-md-4 mb-2">
                            <span class="badge badge-light border px-3 py-2 w-100 text-left">
                                <i class="fas fa-check text-success mr-1"></i>
                                {{ $permission->name }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-muted py-4">
                    {{ __('admin.no_permissions_assigned') }}
                </div>
            @endif
        </div>
    </div>

@endsection
