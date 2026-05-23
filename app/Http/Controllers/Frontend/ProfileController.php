<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $ordersCount = $user->orders()->count();
        $paymentsCount = $user->payment()->count();

        return view('frontend.profile.index', compact(
            'user',
            'ordersCount',
            'paymentsCount'
        ));
    }

    public function updateInfo(Request $request)
    {
        $request->validate([
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $user = Auth::user();
        $user->phone = $request->phone;
        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = Auth::user();

        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        $path = $request->file('image')->store('users', 'public');

        $user->image = $path;
        $user->save();

        return back()->with('success', 'Profile image updated successfully.');
    }

    public function deleteImage()
    {
        $user = Auth::user();

        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        $user->image = null;
        $user->save();

        return back()->with('success', 'Profile image removed successfully.');
    }
}
