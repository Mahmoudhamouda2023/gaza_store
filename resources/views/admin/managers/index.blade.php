@extends('admin.master')

@section('title', __('admin.managers'))

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                {{ __('admin.managers') }}
            </h1>

            <p class="text-muted mb-0">
                {{ __('admin.managers_management_description') }}
            </p>
        </div>

        @can('create managers')
            <a href="{{ route('admin.managers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i>
                {{ __('admin.add_new_account') }}
            </a>
        @endcan
    </div>

    <div class="card shadow border-0 mb-4">

        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ __('admin.accounts_list') }}
            </h6>

            <span class="badge badge-light border">
                {{ __('admin.total') }}:
                {{ $managers->total() }}
            </span>
        </div>

        <div class="card-body border-bottom">
            <form action="{{ route('admin.managers.index') }}" method="GET">

                <div class="row align-items-end">

                    <div class="col-lg-8 col-md-7 mb-3 mb-md-0">
                        <label class="font-weight-bold">
                            {{ __('admin.search') }}
                        </label>

                        <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                            placeholder="{{ __('admin.search_manager_placeholder') }}">
                    </div>

                    <div class="col-lg-4 col-md-5 d-flex">

                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fas fa-search mr-1"></i>
                            {{ __('admin.filter') }}
                        </button>

                        <a href="{{ route('admin.managers.index') }}" class="btn btn-secondary">
                            {{ __('admin.reset') }}
                        </a>

                    </div>
                </div>

            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-hover table-striped mb-0 align-middle">

                    <thead class="thead-light">
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th style="width: 80px;">
                                {{ __('admin.image') }}
                            </th>

                            <th>{{ __('admin.name') }}</th>

                            <th>{{ __('admin.email') }}</th>

                            <th style="width: 160px;">
                                {{ __('admin.role') }}
                            </th>

                            <th style="width: 150px;">
                                {{ __('admin.created_at') }}
                            </th>

                            @canany(['edit managers', 'delete managers'])
                                <th style="width: 180px;" class="text-right">
                                    {{ __('admin.actions') }}
                                </th>
                            @endcanany
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($managers as $manager)

                            @php
                                $roleName = $manager->roles->first()?->name ?? ($manager->type ?? 'N/A');
                            @endphp

                            <tr>

                                <td class="font-weight-bold">
                                    {{ $managers->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    <img src="https://ui-avatars.com/api/?background=4e73df&color=fff&name={{ urlencode($manager->name) }}"
                                        width="45" height="45" class="rounded-circle border"
                                        alt="{{ $manager->name }}">
                                </td>

                                <td class="font-weight-bold">
                                    {{ $manager->name }}
                                </td>

                                <td>
                                    <span class="text-muted">
                                        {{ $manager->email }}
                                    </span>
                                </td>

                                <td>

                                    <span
                                        class="badge px-3 py-2
                                        @if ($roleName === 'manager') badge-primary
                                        @elseif ($roleName === 'employee') badge-info
                                        @elseif ($roleName === 'support') badge-secondary
                                        @else badge-dark @endif">

                                        {{ ucfirst($roleName) }}

                                    </span>

                                </td>

                                <td>
                                    {{ $manager->created_at ? $manager->created_at->format('d M Y') : '-' }}
                                </td>

                                @canany(['edit managers', 'delete managers'])
                                    <td class="text-right">

                                        <div class="btn-group" role="group">

                                            @can('edit managers')
                                                <a href="{{ route('admin.managers.edit', $manager->id) }}"
                                                    class="btn btn-sm btn-info">

                                                    {{ __('admin.edit') }}

                                                </a>
                                            @endcan

                                            @can('delete managers')
                                                <button type="button" class="btn btn-sm btn-danger btn-delete"
                                                    data-id="{{ $manager->id }}">

                                                    {{ __('admin.delete') }}

                                                </button>

                                                <form id="delete-form-{{ $manager->id }}"
                                                    action="{{ route('admin.managers.destroy', $manager->id) }}" method="POST"
                                                    style="display: none;">

                                                    @csrf
                                                    @method('DELETE')

                                                </form>
                                            @endcan

                                        </div>

                                    </td>
                                @endcanany

                            </tr>

                        @empty

                            <tr>
                                <td colspan="@canany(['edit managers', 'delete managers']) 7 @else 6 @endcanany"
                                    class="text-center py-5">

                                    <div class="text-muted">

                                        <i class="fas fa-users fa-2x mb-3 d-block"></i>

                                        {{ __('admin.no_accounts_found') }}

                                    </div>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>
        </div>

        @if ($managers->hasPages())
            <div class="card-footer bg-white">

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">

                    <div class="text-muted mb-2 mb-md-0">

                        {{ __('admin.showing') }}
                        {{ $managers->firstItem() }}

                        {{ __('admin.to') }}
                        {{ $managers->lastItem() }}

                        {{ __('admin.of') }}
                        {{ $managers->total() }}

                        {{ __('admin.results') }}

                    </div>

                    <div class="pagination-wrapper">
                        {{ $managers->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>

                </div>

            </div>
        @endif

    </div>

    <style>
        .table td,
        .table th {
            vertical-align: middle;
            white-space: nowrap;
        }

        .pagination-wrapper nav,
        .pagination {
            margin: 0;
        }

        .page-link {
            border-radius: 6px;
            margin: 0 2px;
            color: #4e73df;
        }

        .page-item.active .page-link {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        @media (max-width: 767px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 10px;
            }

            .btn-group {
                display: flex;
                gap: 5px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.btn-delete').forEach(function(button) {

                button.addEventListener('click', function() {

                    const managerId = this.getAttribute('data-id');

                    if (confirm('{{ __('admin.delete_manager_confirmation') }}')) {

                        document.getElementById('delete-form-' + managerId).submit();

                    }

                });

            });

        });
    </script>

@endsection
