<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Footprint;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();

        $totalRecords = Footprint::count();

        $averageCarbon = round(
            Footprint::avg('carbon_value') ?? 0,
            2
        );

        $highImpactUsers = Footprint::where(
            'impact_level',
            'High Impact'
        )->count();

        $lowCount = Footprint::where(
            'impact_level',
            'Low Impact'
        )->count();

        $mediumCount = Footprint::where(
            'impact_level',
            'Medium Impact'
        )->count();

        $highCount = Footprint::where(
            'impact_level',
            'High Impact'
        )->count();

        $users = User::latest()->get();

        $footprints = Footprint::with('user')->latest()->get();

        return view(
            'admin.dashboard',
            compact(
                'totalUsers',
                'totalRecords',
                'averageCarbon',
                'highImpactUsers',
                'lowCount',
                'mediumCount',
                'highCount',
                'users',
                'footprints'
            )
        );
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return back()->with(
                'error',
                'Admin cannot be deleted'
            );
        }

        $user->delete();

        return back()->with(
            'success',
            'User deleted successfully'
        );
    }

    public function deleteFootprint($id)
    {
        $footprint = Footprint::findOrFail($id);

        $footprint->delete();

        return back()->with(
            'success',
            'Footprint deleted successfully'
        );
    }
}