<?php

namespace App\Http\Controllers\API\Milestones;

use App\Model\Milestones\Hour;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Milestones\HourResource as MilestonesHourResource;

class HourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($projectId = $request->input('projectId')) {
            return MilestonesHourResource::collection(Hour::where('project_id', $projectId)->latest()->paginate(10));
        }
        return MilestonesHourResource::collection(Hour::latest()->paginate(10));
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
            'date'  =>  'required',
            'task_id'  =>  'required',
            'employee_id'  =>  'required'
        ]);

        return Hour::create([
            'date'  =>  $request['date'],
            'time'  =>  $request['time'],
            'work_completed'  =>  $request['work_completed'],
            'task_id'  =>  $request['task_id'],
            'project_id'  =>  $request['project_id'],
            'employee_id'  =>  $request['employee_id'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Hours\Hour  $hour
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hour = Hour::findOrFail($id);

        return response()->json([
            'data' => $hour
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Hours\Hour  $hour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $hour = Hour::findOrFail($id);

        $this->validate($request, [
            'date'  =>  'required',
            'task_id'  =>  'required',
            'employee_id'  =>  'required'
        ]);

        $hour->update($request->all());

        return response()->json(['message' => __('messages.update_success')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Hours\Hour  $hour
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hour = Hour::findOrFail($id);

        // Delete the hour
        $hour->delete();
        return ['message' => 'Data Deleted'];
    }
}
