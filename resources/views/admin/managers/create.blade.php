@extends('admin.master')

@section('title', __('admin.add_manager'))

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                {{ __('admin.add_new_manager') }}
            </h1>

            <p class="text-muted mb-0">
                {{ __('admin.create_manager_description') }}
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
            <form action="{{ route('admin.managers.store') }}" method="POST">
                @csrf

                <input type="hidden" name="role" value="manager">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">
                                {{ __('admin.name') }} <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="{{ __('admin.enter_manager_name') }}" required>

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
                                value="{{ old('email') }}" placeholder="{{ __('admin.enter_manager_email') }}" required>

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
                                {{ __('admin.password') }} <span class="text-danger">*</span>
                            </label>

                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="{{ __('admin.enter_password') }}" required>

                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                            <small class="text-muted">
                                {{ __('admin.password_hint') }}
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="font-weight-bold">
                                {{ __('admin.confirm_password') }} <span class="text-danger">*</span>
                            </label>

                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="{{ __('admin.confirm_password') }}" required>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info">
                    {!! __('admin.manager_account_note') !!}
                </div>

                <div class="d-flex">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>
                        {{ __('admin.save_manager') }}
                    </button>

                    <a href="{{ route('admin.managers.index') }}" class="btn btn-secondary ml-2">
                        {{ __('admin.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
