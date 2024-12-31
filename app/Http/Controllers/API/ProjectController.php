<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Approval;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index($role)
    {
        $approvals = Approval::with('project')->where('approved', '!=', 1)->where('sequence', $role)->get();

        if ($approvals->isEmpty()) {
            return response()->json(['status' => 404, 'message' => 'no projects found.'], 404);
        }

        return response()->json(['status' => 200, 'result' => $approvals], 200);
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|min:1']);
        $project = Project::create($request->only('title'));

        if ($project) {
            return response()->json(['status' => 201, 'result' => $project, 'message' => 'Project created successfully.'], 201);
        }

        return response()->json(['status' => 400, 'message' => 'Project created not successfully.'], 400);
    }

    public function completed()
    {
        $approvals = Approval::whereHas('project', function ($query) {
            $query->where('status', 'completed');
        })->with('project')->get();

        if ($approvals->isEmpty()) {
            return response()->json(['status' => 404, 'message' => 'no projects found.'], 404);
        }

        return response()->json(['status' => 200, 'result' => $approvals], 200);
    }

    public function trashed()
    {
        $approvals = Approval::onlyTrashed()->with('project')->get();

        if ($approvals->isEmpty()) {
            return response()->json(['status' => 404, 'message' => 'no projects found.'], 404);
        }

        return response()->json(['status' => 200, 'result' => $approvals], 200);
    }

    public function update($id)
    {
        $approval = Approval::with('project')->findOrFail($id);
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

            return response()->json(['status' => 200, 'result' => $approval, 'message' => 'Project approved successfully.'], 200);
        }

        return response()->json(['status' => 404, 'message' => 'project is not found.'], 404);
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

            return response()->json(['status' => 200, 'result' => $approval, 'message' => 'Project unapproved successfully.'], 200);
        }

        return response()->json(['status' => 404, 'message' => 'project is not found.'], 404);
    }

    public function destroy($id)
    {
        $approval = Approval::find($id);

        if ($approval) {
            $approval->delete();
            return response()->json(['status' => 200,  'message' => 'Project deleted successfully.'], 200);
        }

        return response()->json(['status' => 404, 'message' => 'Project deleted not successfully.'], 404);
    }

    public function restore($id)
    {
        $approval = Approval::withTrashed()->findOrFail($id);

        if ($approval) {
            $approval->restore();
            return response()->json(['status' => 200, 'result' => $approval, 'message' => 'Project restored successfully.'], 200);
        }

        return response()->json(['status' => 404, 'message' => 'Project restored not successfully.'], 404);
    }

    public function forceDelete($id)
    {
        $approval = Approval::withTrashed()->find($id);

        if ($approval) {
            $approval->forceDelete();
            return response()->json(['status' => 200,  'message' => 'Project permanently deleted successfully.'], 200);
        }

        return response()->json(['status' => 404, 'message' => 'Project permanently deleted successfully.'], 404);
    }
}
