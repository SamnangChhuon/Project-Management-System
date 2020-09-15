<?php

namespace App\Http\Resources\Milestones;

use App\Http\Resources\Projects\ProjectResource;
use App\Model\Milestones\Status;
use App\Model\Projects\Project;
use Illuminate\Http\Resources\Json\JsonResource;

class MilestoneResource extends JsonResource
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
            'name' => $this->name,
            'due_date' => $this->due_date,
            'deliverables' => $this->deliverables,
            'status_id' => $this->status_id,
            'status' => new StatusResource(Status::find($this->status_id)),
            'project_id' => $this->project_id,
            'project' => new ProjectResource(Project::find($this->project_id)),
            'total_hours' => $this->total_hours,
            'created_at' => $this->created_at,
        ];
    }
}
