@extends('admin.master')

@section('title', __('admin.roles'))

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1 text-gray-800">
                {{ __('admin.roles') }}
            </h1>

            <p class="text-muted mb-0">
                {{ __('admin.roles_management_description') }}
            </p>
        </div>

        @can('create roles')
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i>
                {{ __('admin.add_new_role') }}
            </a>
        @endcan

    </div>

    <div class="card shadow border-0">

        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">

            <h6 class="m-0 font-weight-bold text-primary">
                {{ __('admin.roles_list') }}
            </h6>

            <span class="badge badge-light border">
                {{ __('admin.total') }}: {{ $roles->total() }}
            </span>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover table-striped mb-0">

                    <thead class="thead-light">
                        <tr>
                            <th style="width: 70px;">#</th>

                            <th>
                                {{ __('admin.role_name') }}
                            </th>

                            <th style="width: 180px;">
                                {{ __('admin.permissions') }}
                            </th>

                            <th style="width: 180px;">
                                {{ __('admin.created_at') }}
                            </th>

                            <th style="width: 240px;" class="text-right">
                                {{ __('admin.actions') }}
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($roles as $role)

                            <tr>

                                <td class="font-weight-bold">
                                    {{ $roles->firstItem() + $loop->index }}
                                </td>

                                <td>

                                    <span class="font-weight-bold">
                                        {{ ucfirst($role->name) }}
                                    </span>

                                    @if ($role->name === 'admin')
                                        <span class="badge badge-danger ml-2">
                                            {{ __('admin.protected') }}
                                        </span>
                                    @endif

                                </td>

                                <td>

                                    <span class="badge badge-info px-3 py-2">
                                        {{ $role->permissions_count }}
                                        {{ __('admin.permissions') }}
                                    </span>

                                </td>

                                <td>
                                    {{ $role->created_at ? $role->created_at->format('d M Y') : '-' }}
                                </td>

                                <td class="text-right">

                                    <div class="btn-group" role="group">

                                        @can('view roles')
                                            <a href="{{ route('admin.roles.show', $role->id) }}" class="btn btn-sm btn-info">

                                                {{ __('admin.view') }}
                                            </a>
                                        @endcan

                                        @can('edit roles')
                                            <a href="{{ route('admin.roles.edit', $role->id) }}"
                                                class="btn btn-sm btn-warning">

                                                {{ __('admin.edit') }}
                                            </a>
                                        @endcan

                                        @can('delete roles')
                                            @if ($role->name !== 'admin')
                                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('{{ __('admin.delete_role_confirmation') }}');">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        {{ __('admin.delete') }}
                                                    </button>

                                                </form>
                                            @endif
                                        @endcan

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    {{ __('admin.no_roles_found') }}
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if ($roles->hasPages())
            <div class="card-footer bg-white">
                {{ $roles->links('pagination::bootstrap-4') }}
            </div>
        @endif

    </div>

@endsection
