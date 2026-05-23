@extends('admin.master')

@section('title', __('admin.employees'))

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 text-gray-800">
            {{ __('admin.employees') }}
        </h1>

        @can('create employees')
            <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">
                {{ __('admin.add_new_employee') }}
            </a>
        @endcan

    </div>

    <div class="card shadow border-0">

        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ __('admin.employees_list') }}
            </h6>
        </div>

        <div class="card-body border-bottom">

            <form action="{{ route('admin.employees.index') }}" method="GET">

                <div class="row align-items-end">

                    <div class="col-md-8 mb-3 mb-md-0">

                        <label>{{ __('admin.search') }}</label>

                        <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                            placeholder="{{ __('admin.search_employee_placeholder') }}">

                    </div>

                    <div class="col-md-4">

                        <button type="submit" class="btn btn-primary">
                            {{ __('admin.filter') }}
                        </button>

                        <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary ml-1">

                            {{ __('admin.reset') }}
                        </a>

                    </div>

                </div>

            </form>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead class="thead-light">
                        <tr>
                            <th>#</th>

                            <th>{{ __('admin.image') }}</th>

                            <th>{{ __('admin.name') }}</th>

                            <th>{{ __('admin.email') }}</th>

                            <th>{{ __('admin.role') }}</th>

                            <th>{{ __('admin.created_at') }}</th>

                            @canany(['edit employees', 'delete employees'])
                                <th class="text-right">
                                    {{ __('admin.actions') }}
                                </th>
                            @endcanany
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($employees as $employee)

                            <tr>

                                <td>
                                    {{ $employees->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    <img src="https://ui-avatars.com/api/?background=random&name={{ urlencode($employee->name) }}"
                                        width="45" height="45" class="rounded-circle border">
                                </td>

                                <td>{{ $employee->name }}</td>

                                <td>{{ $employee->email }}</td>

                                <td>
                                    <span class="badge badge-primary">
                                        {{ __('admin.employee') }}
                                    </span>
                                </td>

                                <td>
                                    {{ $employee->created_at ? $employee->created_at->format('d M Y') : '-' }}
                                </td>

                                @canany(['edit employees', 'delete employees'])
                                    <td class="text-right">

                                        @can('edit employees')
                                            <a href="{{ route('admin.employees.edit', $employee->id) }}"
                                                class="btn btn-sm btn-info">

                                                {{ __('admin.edit') }}
                                            </a>
                                        @endcan

                                        @can('delete employees')
                                            <button type="button" class="btn btn-sm btn-danger btn-delete"
                                                data-id="{{ $employee->id }}">

                                                {{ __('admin.delete') }}
                                            </button>

                                            <form id="delete-form-{{ $employee->id }}"
                                                action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST"
                                                style="display: none;">

                                                @csrf
                                                @method('DELETE')

                                            </form>
                                        @endcan

                                    </td>
                                @endcanany

                            </tr>

                        @empty

                            <tr>
                                <td colspan="@canany(['edit employees', 'delete employees']) 7 @else 6 @endcanany"
                                    class="text-center text-muted py-4">

                                    {{ __('admin.no_employees_found') }}
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if ($employees->hasPages())
            <div class="card-footer bg-white">
                {{ $employees->links() }}
            </div>
        @endif

    </div>

@endsection
