@extends('admin.master')

@section('title', __('admin.activity_logs'))

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('back/css/admin-datatables.css') }}">
@endsection

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="h3 admin-page-title">
                {{ __('admin.activity_logs') }}
            </h1>

            <p class="admin-page-subtitle">
                Track admin actions, model changes, and system activities from one place.
            </p>
        </div>
    </div>

    <div class="card admin-card">
        <div class="admin-card-header">
            <div>
                <h6>
                    <i class="fas fa-history mr-1"></i>
                    {{ __('admin.activity_logs') }}
                </h6>

                <span>Total logs: {{ $logs->count() }}</span>
            </div>

            <span>
                <i class="fas fa-table mr-1"></i>
                DataTable View
            </span>
        </div>

        <div class="admin-table-wrapper">
            <div class="table-responsive">
                <table class="table table-bordered table-hover admin-data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('admin.admin') }}</th>
                            <th>{{ __('admin.action') }}</th>
                            <th>{{ __('admin.model') }}</th>
                            <th>{{ __('admin.description') }}</th>
                            <th>{{ __('admin.date') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>
                                    <span class="admin-index">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>

                                <td>
                                    <div class="admin-name" title="{{ $log->admin->name ?? '-' }}">
                                        {{ $log->admin->name ?? '-' }}
                                    </div>
                                </td>

                                <td>
                                    @if ($log->action == 'created')
                                        <span class="admin-badge success">
                                            <i class="fas fa-plus-circle"></i>
                                            {{ __('admin.' . $log->action) }}
                                        </span>
                                    @elseif ($log->action == 'updated')
                                        <span class="admin-badge warning">
                                            <i class="fas fa-edit"></i>
                                            {{ __('admin.' . $log->action) }}
                                        </span>
                                    @elseif ($log->action == 'deleted')
                                        <span class="admin-badge danger">
                                            <i class="fas fa-trash"></i>
                                            {{ __('admin.' . $log->action) }}
                                        </span>
                                    @else
                                        <span class="admin-badge secondary">
                                            <i class="fas fa-info-circle"></i>
                                            {{ __('admin.' . $log->action) }}
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <span class="admin-category">
                                        {{ $log->model }}
                                    </span>
                                </td>

                                <td>
                                    <div class="admin-description" title="{{ $log->description }}">
                                        {{ $log->description }}
                                    </div>
                                </td>

                                <td>
                                    {{ $log->created_at->format('d M Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-history fa-2x mb-3 text-gray-400"></i>
                                    <div>{{ __('admin.no_logs_found') }}</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('back/js/admin-datatables.js') }}"></script>
@endsection
