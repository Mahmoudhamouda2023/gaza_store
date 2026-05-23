@extends('admin.master')

@section('title', __('admin.edit_manager'))

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                {{ __('admin.edit_manager') }}
            </h1>

            <p class="text-muted mb-0">
                {{ __('admin.update_manager_information') }}
            </p>
        </div>

        <a href="{{ route('admin.managers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>
            {{ __('admin.back') }}
        </a>
    </div>

    <div class="card shadow border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ __('admin.manager_information') }}
            </h6>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.managers.update', $manager->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">
                                {{ __('admin.name') }} <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $manager->name) }}" placeholder="{{ __('admin.enter_manager_name') }}"
                                required>

                            @error('name')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">
                                {{ __('admin.email') }} <span class="text-danger">*</span>
                            </label>

                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $manager->email) }}"
                                placeholder="{{ __('admin.enter_manager_email') }}" required>

                            @error('email')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">
                                {{ __('admin.role') }}
                            </label>

                            <input type="text" class="form-control" value="{{ __('admin.manager') }}" disabled>

                            <small class="text-muted">
                                {{ __('admin.role_fixed_message') }}
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">
                                {{ __('admin.created_at') }}
                            </label>

                            <input type="text" class="form-control"
                                value="{{ $manager->created_at ? $manager->created_at->format('d M Y - h:i A') : '-' }}"
                                disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">
                                {{ __('admin.new_password') }}
                            </label>

                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="{{ __('admin.leave_empty_password') }}">

                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                            <small class="text-muted">
                                {{ __('admin.keep_current_password') }}
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="font-weight-bold">
                                {{ __('admin.confirm_new_password') }}
                            </label>

                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="{{ __('admin.confirm_new_password') }}">
                        </div>
                    </div>

                </div>

                <div class="alert alert-warning">
                    {{ __('admin.manager_password_note') }}
                </div>

                <div class="d-flex">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>
                        {{ __('admin.update_manager') }}
                    </button>

                    <a href="{{ route('admin.managers.index') }}" class="btn btn-secondary ml-2">
                        {{ __('admin.cancel') }}
                    </a>
                </div>

            </form>
        </div>
    </div>

@endsection
