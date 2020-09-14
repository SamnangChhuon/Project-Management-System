<?php

namespace App\Http\Resources\Tasks;

use App\Http\Resources\Milestones\MilestoneResource;
use App\Http\Resources\Projects\ProjectResource;
use App\Http\Resources\Users\UserResource;
use App\Model\Milestones\Milestone;
use App\Model\Projects\Project;
use App\Model\Tasks\Status;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'task_name' => $this->task_name,
            'instructions' => $this->instructions,
            'total_hours' => $this->total_hours,
            'status_id' => $this->status_id,
            'status' => new StatusResource(Status::find($this->status_id)),
            'milestone_id' => $this->milestone_id,
            'milestone' => new MilestoneResource(Milestone::find($this->milestone_id)),
            'project_id' => $this->project_id,
            'project' => new ProjectResource(Project::find($this->project_id)),
            'employee_id' => $this->employee_id,
            'employee' => new UserResource(User::find($this->employee_id)),
            'created_at' => $this->created_at,
        ];
    }
}
