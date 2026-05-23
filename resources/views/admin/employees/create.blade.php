@extends('admin.master')

@section('title', __('admin.add_employee'))

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">
            {{ __('admin.add_new_employee') }}
        </h1>

        <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">
            {{ __('admin.back') }}
        </a>
    </div>

    <div class="card shadow border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ __('admin.employee_information') }}
            </h6>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.employees.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>{{ __('admin.name') }} <span class="text-danger">*</span></label>

                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="{{ __('admin.enter_employee_name') }}" required>

                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>{{ __('admin.email') }} <span class="text-danger">*</span></label>

                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="{{ __('admin.enter_employee_email') }}" required>

                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>{{ __('admin.password') }} <span class="text-danger">*</span></label>

                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="{{ __('admin.enter_password') }}" required>

                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label>{{ __('admin.confirm_password') }} <span class="text-danger">*</span></label>

                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="{{ __('admin.confirm_password') }}" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    {{ __('admin.save_employee') }}
                </button>

                <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary ml-2">
                    {{ __('admin.cancel') }}
                </a>
            </form>
        </div>
    </div>

@endsection
