<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    function index()
    {
        $admin = Auth::guard('admin')->user();

        if ($admin->hasRole('admin')) {
            $totalOrders = \App\Models\Order::count();
            $totalRevenue = \App\Models\Payment::where('status', 'paid')->sum('total');
            $totalCustomers = \App\Models\User::count();
            $totalPayments = \App\Models\Payment::count();
            $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
            $paidPayments = \App\Models\Payment::where('status', 'paid')->count();
            $latestOrders = \App\Models\Order::with('user')->latest()->take(5)->get();
            $latestPayments = \App\Models\Payment::with(['user', 'order'])->latest()->take(5)->get();

            return view('admin.index', compact(
                'totalOrders',
                'totalRevenue',
                'totalCustomers',
                'totalPayments',
                'pendingOrders',
                'paidPayments',
                'latestOrders',
                'latestPayments'
            ));
        }

        if ($admin->hasRole('manager')) {
            $totalRevenue = \App\Models\Payment::where('status', 'paid')->sum('total');
            $totalCustomers = \App\Models\User::count();
            $totalPayments = \App\Models\Payment::count();
            $paidPayments = \App\Models\Payment::where('status', 'paid')->count();
            $latestPayments = \App\Models\Payment::with(['user', 'order'])->latest()->take(5)->get();

            return view('admin.dashboards.manager', compact(
                'totalRevenue',
                'totalCustomers',
                'totalPayments',
                'paidPayments',
                'latestPayments'
            ));
        }

        if ($admin->hasRole('employee')) {
            $totalOrders = \App\Models\Order::count();
            $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
            $latestOrders = \App\Models\Order::with('user')->latest()->take(5)->get();

            return view('admin.dashboards.employee', compact(
                'totalOrders',
                'pendingOrders',
                'latestOrders'
            ));
        }

        abort(403);
    }

    function profile()
    {
        $admin = Auth::guard('admin')->user();

        return view('admin.profile', compact('admin'));
    }

    function profile_data(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name'             => 'required|string|max:255',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'current_password' => 'nullable',
            'password'         => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $admin->name = $request->name;

        if ($request->filled('current_password') && $request->filled('password')) {
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors([
                    'current_password' => 'Current password is incorrect',
                ]);
            }

            $admin->password = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $img_name = rand() . time() . $file->getClientOriginalName();

            $file->move(public_path('images'), $img_name);

            if ($admin->image) {
                File::delete(public_path('images/' . $admin->image->path));

                $admin->image()->update([
                    'path' => $img_name,
                ]);
            } else {
                $admin->image()->create([
                    'path' => $img_name,
                ]);
            }
        }

        $admin->save();

        flash()->success('Profile updated successfully');

        return back();
    }

    function orders()
    {
        if (request()->has('id')) {
            $id = request()->id;

            Auth::guard('admin')->user()
                ?->notifications
                ?->find($id)
                ?->markAsRead();
        }

        return 'Order page';
    }

    function notifications()
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return redirect()->route('admin.login');
        }

        $admin->unreadNotifications->markAsRead();

        $notifications = $admin->notifications()
            ->latest()
            ->paginate(20);

        return view('admin.notifications', compact('notifications'));
    }

    public function roles()
    {
        $roles = \App\Models\Role::latest()->paginate(10);

        return view('admin.roles.index', compact('roles'));
    }
    public function activityLogs()
    {
        $logs = \App\Models\ActivityLog::with('admin')
            ->latest()
            ->paginate(15);

        return view('admin.activity_logs.index', compact('logs'));
    }
}
