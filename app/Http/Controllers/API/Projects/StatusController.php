<?php

namespace App\Http\Controllers\API\Projects;

use App\Model\Projects\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Status::latest()->paginate(10);
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
            'status'  =>  'required|string|max:191|unique:project_status',
        ]);

        return Client::create([
            'status'  =>  $request['status']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Projects\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function show(Status $status)
    {
        $status = Status::findOrFail($status);

        return response()->json([
            'data' => $status
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Projects\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        $status = Status::findOrFail($status);

        $this->validate($request, [
            'status'  =>  'required|string|max:191|unique:project_status',
        ]);

        $status->update($request->all());

        return response()->json(['message' => __('messages.update_success')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Projects\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        $status = Status::findOrFail($status);

        // Delete the status
        $status->withTrashed();
        return ['message' => 'Data Deleted'];
    }
}
