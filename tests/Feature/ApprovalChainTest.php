<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Approval;
use App\Models\Project;
use Tests\TestCase;

class ApprovalChainTest extends TestCase
{
    public function test_store_project_success()
    {
    $data = ['title' => 'new project'];
    $response = $this->postJson('/api/approve/project/store', $data);

        $response->assertStatus(201)->assertJson([
            'status' => 201,
            'message' => 'Project created successfully.',
        ]);

        $this->assertDatabaseHas('projects', [
            'title' => 'new project',
        ]);
    }

    public function test_update_project_success()
    {
        $project = Project::create(['title' => 'new project']);

        $response = $this->putJson("/api/approve/update/{$project->id}");

        $response->assertStatus(200)->assertJson([
            'status' => 200,
            'message' => 'Project approved successfully.',
        ]);
    }

    public function test_completed_project_success()
    {
        $maxRole = Admin::max('role') + 1;
        $project = Project::create(['title' => 'new project7']);
        $approval = Approval::where('project_id', $project->id)->first();

        for ($i = 1; $i <= $maxRole; $i++) {
            if ($approval->sequence < $maxRole) {
                $approval->increment('sequence');
        
                if ($approval->sequence == $maxRole) {
                    $approval->update(['approved' => 1]);
                    $project->update(['status' => 'completed']);
                }
            }
        }

        $response = $this->putJson("/api/approve/update/{$project->id}");

        $response->assertStatus(200)->assertJson([
            'status' => 200,
            'message' => 'Project approved successfully.',
        ]);
    }
}
