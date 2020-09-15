<?php

namespace App\Http\Controllers\API\Projects;

use App\Model\Projects\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Projects\ProjectResource;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($clientId = $request->input('clientId')) {
            return ProjectResource::collection(Project::where('client_id', $clientId)->latest()->paginate(10));
        }
        if ($request->input('getType') == 'all') {
            return ProjectResource::collection(Project::all());
        }
        return ProjectResource::collection(Project::latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'project_name'  =>  'required|string|max:191',
            'client_id'  =>  'required',
            'status_id'  =>  'required',
            'project_manager_id'  =>  'required',
        ]);

        return Project::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Projects\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);

        return response()->json([
            'data' => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Projects\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $this->validate($request, [
            'project_name'  =>  'required|string|max:191',
            'client_id'  =>  'required',
            'status_id'  =>  'required',
            'project_manager_id'  =>  'required',
        ]);

        $project->update($request->all());

        return response()->json(['message' => __('messages.update_success')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Projects\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        // Delete the project
        $project->delete();
        return ['message' => 'Data Deleted'];
    }
}
