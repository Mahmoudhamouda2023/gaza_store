<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class ManagerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $managers = Admin::where('type', '!=', 'admin')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->with('roles')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.managers.index', compact('managers', 'search'));
    }

    public function create()
    {
        $roles = Role::where('guard_name', 'admin')
            ->where('name', '!=', 'admin')
            ->orderBy('name')
            ->get();

        return view('admin.managers.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => [
                'required',
                'string',
                Rule::exists('roles', 'name')->where('guard_name', 'admin'),
            ],
        ]);

        $role = Role::where('name', $validated['role'])
            ->where('guard_name', 'admin')
            ->where('name', '!=', 'admin')
            ->firstOrFail();

        $manager = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'type' => $role->name,
            'email_verified_at' => now(),
        ]);

        $manager->syncRoles([$role->name]);

        return redirect()
            ->route('admin.managers.index')
            ->with('success', 'Account created successfully.');
    }

    public function edit(Admin $manager)
    {
        abort_if($manager->hasRole('admin') || $manager->type === 'admin', 404);

        $roles = Role::where('guard_name', 'admin')
            ->where('name', '!=', 'admin')
            ->orderBy('name')
            ->get();

        return view('admin.managers.edit', compact('manager', 'roles'));
    }

    public function update(Request $request, Admin $manager)
    {
        abort_if($manager->hasRole('admin') || $manager->type === 'admin', 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email,' . $manager->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => [
                'required',
                'string',
                Rule::exists('roles', 'name')->where('guard_name', 'admin'),
            ],
        ]);

        $role = Role::where('name', $validated['role'])
            ->where('guard_name', 'admin')
            ->where('name', '!=', 'admin')
            ->firstOrFail();

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'type' => $role->name,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        $manager->update($data);
        $manager->syncRoles([$role->name]);

        return redirect()
            ->route('admin.managers.index')
            ->with('success', 'Account updated successfully.');
    }

    public function destroy(Admin $manager)
    {
        abort_if($manager->hasRole('admin') || $manager->type === 'admin', 404);

        if (auth('admin')->id() === $manager->id) {
            return redirect()
                ->route('admin.managers.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $manager->delete();

        return redirect()
            ->route('admin.managers.index')
            ->with('success', 'Account deleted successfully.');
    }
}
