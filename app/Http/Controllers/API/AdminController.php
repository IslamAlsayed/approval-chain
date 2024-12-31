<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function store(Request $request)
    {
        if (Admin::where('name', $request->input('name'))->first()) {
            return redirect()->back()->with('error', 'this is name exist.');
        }

        $request->validate(['name' => 'required|string|min:1|unique:admins,name']);

        $roleIntval = intval(preg_replace('/\D/', '', $request->input('name')));

        $admin = Admin::create(['name' => $request->input('name'), 'role' => $roleIntval]);

        if ($admin) {
            return response()->json(['status' => 201, 'result' => $admin, 'message' => 'Admin created successfully.'], 201);
        }

        return response()->json(['status' => 201, 'message' => 'Admin created not successfully.'], 201);
    }
}
