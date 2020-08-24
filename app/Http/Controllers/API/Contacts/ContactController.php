<?php

namespace App\Http\Controllers\API\Contacts;

use App\Model\Contacts\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Contact::latest()->paginate(10);
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
            'first_name'  =>  'required|string|max:191|unique:contacts',
            'last_name'  =>  'required|string|max:191|unique:contacts',
            'email'  =>  'required|string|max:191|email|unique:contacts',
        ]);

        return Contact::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Contacts\Contacts  $contacts
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $status = Contact::findOrFail($id);

        return response()->json([
            'data' => $status
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Contacts\Contacts  $contacts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $status = Contact::findOrFail($id);

        $this->validate($request, [
            'first_name'  =>  'required|string|max:191|unique:contacts',
            'last_name'  =>  'required|string|max:191|unique:contacts',
            'email'  =>  'required|string|max:191|email|unique:contacts',
        ]);

        $status->update($request->all());

        return response()->json(['message' => __('messages.update_success')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Contacts\Contacts  $contacts
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = Contact::findOrFail($id);

        // Delete the status
        $status->delete();
        return ['message' => 'Data Deleted'];
    }
}
