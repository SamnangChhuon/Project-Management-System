<?php

namespace App\Http\Resources\Projects;

use App\Http\Resources\Contacts\ClientResource;
use App\Http\Resources\Users\UserResource;
use App\Model\Contacts\Client;
use App\Model\Projects\Status;
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
            'budget' => $this->budget,
            'active' => $this->active,
            'total_hours' => $this->total_hours,
            'labor_costs' => $this->labor_costs,
            'material_costs' => $this->material_costs,
            'total_costs' => $this->total_costs,
            'project_manager_id' => $this->project_manager_id,
            'project_manager' => new UserResource(User::find($this->project_manager_id)),
            'status_id' => $this->status_id,
            'status' => new StatusResource(Status::find($this->status_id)),
            'client_id' => $this->client_id,
            'client' => new ClientResource(Client::find($this->client_id)),
            'created_at' => $this->created_at,
        ];
    }
}
