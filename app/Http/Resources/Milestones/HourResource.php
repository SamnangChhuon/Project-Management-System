<?php

namespace App\Http\Resources\Milestones;

use App\Http\Resources\Projects\ProjectResource;
use App\Http\Resources\Tasks\TaskResource;
use App\Http\Resources\Users\UserResource;
use App\Model\Projects\Project;
use App\Model\Tasks\Task;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class HourResource extends JsonResource
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
            'date' => $this->date,
            'time' => $this->time,
            'work_completed' => $this->work_completed,
            'task_id' => $this->task_id,
            'task' => new TaskResource(Task::find($this->task_id)),
            'project_id' => $this->project_id,
            'project' => new ProjectResource(Project::find($this->project_id)),
            'employee_id' => $this->employee_id,
            'employee' => new UserResource(User::find($this->employee_id)),
        ];
    }
}
