<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':admin']);
    }

    // List all staff members
    public function index()
    {
        $staff = User::where('role', 'staff')->get();
        return view('admin.staff.index', compact('staff'));
    }

    // Show edit form
    public function edit($id)
    {
        $staff = User::findOrFail($id);
        return view('admin.staff.edit', compact('staff'));
    }

    // Update staff member
    public function update(Request $request, $id)
    {
        $staff = User::findOrFail($id);
        $staff->update($request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
        ]));
        return redirect()->route('admin.staff.index')->with('success', 'Staff updated!');
    }

    // Delete staff member
    public function destroy($id)
    {
        $staff = User::findOrFail($id);
        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Staff deleted!');
    }
} 