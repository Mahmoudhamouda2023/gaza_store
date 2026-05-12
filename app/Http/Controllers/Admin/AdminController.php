<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Console\NotificationTableCommand;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function index()
    {
        return view('admin.index');
    }

    function profile()
    {
        $admin = Auth::user();
        return view('admin.profile', compact('admin'));
    }

    function profile_data(Request $request)
    {
        /** @var \App\Models\User $admin */
        $admin = Auth::user();

        $request->validate([
            'name'             => 'required|string|max:255',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'current_password' => 'nullable',
            'password'         => ['nullable', 'confirmed', Password::min(8)],
        ]);

        // تحديث الاسم
        $admin->name = $request->name;

        // تحديث الباسورد
        if ($request->filled('current_password') && $request->filled('password')) {
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $admin->password = Hash::make($request->password);
        }

        // تحديث الصورة
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $img_name = rand() . time() . $file->getClientOriginalName();
            $file->move(public_path('images'), $img_name);

            if ($admin->image) {
                File::delete(public_path('images/' . $admin->image->path));
                $admin->image()->update(['path' => $img_name]);
            } else {
                $admin->image()->create(['path' => $img_name]);
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
            Auth::user()->notifications->find($id)->markAsRead();
        }

        return 'Order page';
    }
    function notifications()
    {
        /** @var \App\Models\User $admin */
        $admin = Auth::user();
        $admin->unreadNotifications->markAsRead();

        $notifications = $admin->notifications()->latest()->paginate(20);

        return view('admin.notifications', compact('notifications'));
    }
}
