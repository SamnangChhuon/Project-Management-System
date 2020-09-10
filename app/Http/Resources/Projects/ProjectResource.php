<?php

namespace App\Http\Resources\Projects;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'project_name' => $this->project_name,
            'hourly_rate' => $this->hourly_rate,
            'project_manager_id' => $this->project_manager_id,
            'project_manager' => User::find($this->project_manager_id),
            'budget' => $this->budget,
            'created_at' => $this->created_at,
        ];
    }
}
