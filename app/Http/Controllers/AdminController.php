<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function create()
    {
        $admins = Admin::all();
        return view('approvals.adminCreate', compact('admins'));
    }

    public function store(Request $request)
    {
        if (Admin::where('name', $request->input('name'))->first()) {
            return redirect()->back()->with('error', 'this is name exist.');
        }

        $request->validate(['name' => 'required|string|min:1|unique:admins,name']);

        $roleIntval = intval(preg_replace('/\D/', '', $request->input('name')));

        $admin = Admin::create(['name' => $request->input('name'), 'role' => $roleIntval]);

        if ($admin) {
            return redirect()->back()->with('success', 'Admin created successfully.');
        }

        return redirect()->back()->with('error', 'Admin created not successfully.');
    }
}
