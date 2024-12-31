<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index($role)
    {
        $roleIntval = intval(preg_replace('/\D/', '', $role));
        $approvals = Approval::with('project')->where('approved', '!=', 1)->where('sequence', $roleIntval)->get();

        return view('approvals.' . $role, compact('role', 'approvals'));
    }

    public function create()
    {
        return view('approvals.create');
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|min:1']);
        $project = Project::create($request->only('title'));

        if ($project) {
            return redirect()->back()->with('success', 'Project created successfully.');
        }

        return redirect()->back()->with('success', 'Project created not successfully.');
    }

    public function completed()
    {
        $approvals = Approval::whereHas('project', function ($query) {
            $query->where('status', 'completed');
        })->with('project')->get();

        if ($approvals->isEmpty()) {
            return redirect()->back()->with('error', 'no projects found.');
        }

        return view('approvals.completed', compact('approvals'));
    }

    public function trashed()
    {
        $approvals = Approval::onlyTrashed()->with('project')->get();

        if ($approvals->isEmpty()) {
            return redirect()->back()->with('error', 'no projects found.');
        }

        return view('approvals.trashed', compact('approvals'));
    }

    public function update($id)
    {
        $approval = Approval::findOrFail($id);

        if ($approval) {
            if ($approval->sequence < 4) {
                $approval->increment('sequence');

                if ($approval->sequence == 4) {
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

        if ($approval) {
            $approval->decrement('sequence');

            if ($approval->sequence != 4) {
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
