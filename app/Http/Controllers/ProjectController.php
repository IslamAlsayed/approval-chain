<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Project;
use App\Models\Admin;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index($role)
    {
        $admin = Admin::find($role);
        $admins = Admin::all();
        $approvals = Approval::with('project')->where('approved', '!=', 1)->where('sequence', $role)->get();

        return view('approvals.data', compact('admin', 'admins', 'approvals'));
    }

    public function create()
    {
        $admins = Admin::all();
        return view('approvals.projectCreate', compact('admins'));
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|min:1']);
        $project = Project::create($request->only('title'));

        if ($project) {
            return redirect()->back()->with('success', 'Project created successfully.');
        }

        return redirect()->back()->with('error', 'Project created not successfully.');
    }

    public function completed()
    {
        $admins = Admin::all();
        $approvals = Approval::whereHas('project', function ($query) {
            $query->where('status', 'completed');
        })->with('project')->get();

        return view('approvals.completed', compact('admins', 'approvals'));
    }

    public function trashed()
    {
        $admins = Admin::all();
        $approvals = Approval::onlyTrashed()->with('project')->get();

        return view('approvals.trashed', compact('admins', 'approvals'));
    }

    public function update($id)
    {
        $approval = Approval::findOrFail($id);
        $maxRole = Admin::max('role') + 1;

        if ($approval) {
            if ($approval->sequence < $maxRole) {
                $approval->increment('sequence');

                if ($approval->sequence == $maxRole) {
                    $approval->update(['approved' => 1]);

                    $project = Project::find($approval->project_id);
                    if ($project) {
                        $project->update(['status' => 'completed']);
                    }
                }
            }

            return redirect()->back()->with('success', 'Project approved successfully.');
        }

        return redirect()->back()->with('error', 'Project approved not successfully.');
    }

    public function unapproved($id)
    {
        $approval = Approval::findOrFail($id);
        $maxRole = Admin::max('role') + 1;

        if ($approval) {
            $approval->decrement('sequence');

            if ($approval->sequence != $maxRole) {
                $approval->update(['approved' => 0]);

                $project = Project::find($approval->project_id);
                if ($project) {
                    $project->update(['status' => 'pending']);
                }
            }

            return redirect()->back()->with('success', 'Project restored successfully.');
        }

        return redirect()->back()->with('error', 'Project restore failed.');
    }

    public function destroy($id)
    {
        $approval = Approval::findOrFail($id);

        if ($approval) {
            $approval->delete();
            return redirect()->back()->with('success', 'Project deleted successfully.');
        }

        return redirect()->back()->with('success', 'Project deleted not successfully.');
    }

    public function restore($id)
    {
        $approval = Approval::withTrashed()->findOrFail($id);

        if ($approval) {
            $approval->restore();
            return redirect()->back()->with('success', 'Project restored successfully.');
        }

        return redirect()->back()->with('success', 'Project restored not successfully.');
    }

    public function forceDelete($id)
    {
        $approval = Approval::withTrashed()->findOrFail($id);

        if ($approval) {
            $approval->forceDelete();
            return redirect()->back()->with('success', 'Project permanently deleted successfully.');
        }

        return redirect()->back()->with('success', 'Project permanent deleted not successful.');
    }
}
