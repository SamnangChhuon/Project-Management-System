<?php

namespace App\Http\Controllers\API\Tasks;

use App\Model\Tasks\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tasks\TaskResource;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TaskResource::collection(Task::latest()->paginate(10));
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
            'task_name'  =>  'required|string|max:191',
            'status_id'  =>  'required',
            'milestone_id'  =>  'required',
            'employee_id'  =>  'required',
        ]);

        return Task::create([
            'task_name'  =>  $request['task_name'],
            'instructions'  =>  $request['instructions'],
            'total_hours'  =>  $request['total_hours'],
            'status_id'  =>  $request['status_id'],
            'milestone_id'  =>  $request['milestone_id'],
            'project_id'  =>  $request['project_id'],
            'employee_id'  =>  $request['employee_id']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Tasks\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);

        return response()->json([
            'data' => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Tasks\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $this->validate($request, [
            'task_name'  =>  'required|string|max:191',
            'status_id'  =>  'required',
            'milestone_id'  =>  'required',
            'employee_id'  =>  'required',
        ]);

        $task->update($request->all());

        return response()->json(['message' => __('messages.update_success')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Tasks\Task  $tasks
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        // Delete the task
        $task->delete();
        return ['message' => 'Data Deleted'];
    }

    public function getTasks() {
        return TaskResource::collection(Task::all());
    }
}
