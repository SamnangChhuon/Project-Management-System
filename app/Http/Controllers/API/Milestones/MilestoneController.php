<?php

namespace App\Http\Controllers\API\Milestones;

use App\Model\Milestones\Milestone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Milestones\MilestoneResource;

class MilestoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MilestoneResource::collection(Milestone::latest()->paginate(10));
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
            'name'  =>  'required|string|max:191',
            'status_id'  =>  'required',
        ]);

        return Milestone::create([
            'name'  =>  $request['name'],
            'due_date'  =>  $request['due_date'],
            'deliverables'  =>  $request['deliverables'],
            'status_id'  =>  $request['status_id'],
            'project_id'  =>  $request['project_id'],
            'total_hours'  =>  $request['total_hours'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Milestones\Milestone  $milestone
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $milestone = Milestone::findOrFail($id);

        return response()->json([
            'data' => $milestone
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Milestones\Milestone  $milestone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $milestone = Milestone::findOrFail($id);

        $this->validate($request, [
            'name'  =>  'required|string|max:191',
            'status_id'  =>  'required',
        ]);

        $milestone->update($request->all());

        return response()->json(['message' => __('messages.update_success')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Milestones\Milestone  $milestone
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $milestone = Milestone::findOrFail($id);

        // Delete the milestone
        $milestone->delete();
        return ['message' => 'Data Deleted'];
    }
}
