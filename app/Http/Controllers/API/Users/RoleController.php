<?php

namespace App\Http\Controllers\API\Users;

use App\Model\Users\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Role::get();
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
            'name'  =>  'required|string|max:191|unique:project_statuses',
        ]);

        return Role::create([
            'name'  =>  $request['name']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Projects\Role  $status
     * @return \Illuminate\Http\Response
     */
    public function show(Role $status)
    {
        $status = Role::findOrFail($status);

        return response()->json([
            'data' => $status
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Projects\Role  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $status = Role::findOrFail($id);

        $this->validate($request, [
            'name'  =>  'required|string|max:191|unique:project_statuses',
        ]);

        $status->update($request->all());

        return response()->json(['message' => __('messages.update_success')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Projects\Role  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = Role::findOrFail($id);

        // Delete the status
        $status->delete();
        return ['message' => 'Data Deleted'];
    }
}
