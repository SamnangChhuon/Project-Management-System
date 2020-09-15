<?php

namespace App\Http\Controllers\API\Milestones;

use App\Model\Milestones\Cost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Milestones\CostResource as MilestonesCostResource;

class CostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($projectId = $request->input('projectId')) {
            return MilestonesCostResource::collection(Cost::where('project_id', $projectId)->latest()->paginate(10));
        }
        return MilestonesCostResource::collection(Cost::latest()->paginate(10));
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
        ]);

        return Cost::create([
            'name'  =>  $request['name'],
            'description'  =>  $request['description'],
            'price_per'  =>  $request['price_per'],
            'quantity'  =>  $request['quantity'],
            'total_cost'  =>  $request['total_cost'],
            'project_id'  =>  $request['project_id'],
            'milesone_id'  =>  $request['milesone_id'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Costs\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cost = Cost::findOrFail($id);

        return response()->json([
            'data' => $cost
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Costs\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cost = Cost::findOrFail($id);

        $this->validate($request, [
            'name'  =>  'required|string|max:191',
        ]);

        $cost->update($request->all());

        return response()->json(['message' => __('messages.update_success')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Costs\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cost = Cost::findOrFail($id);

        // Delete the cost
        $cost->delete();
        return ['message' => 'Data Deleted'];
    }
}
