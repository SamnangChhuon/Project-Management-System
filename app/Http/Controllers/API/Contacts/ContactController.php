<?php

namespace App\Http\Controllers\API\Contacts;

use App\Model\Contacts\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Contacts\ContactResource;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($clientId = $request->input('clientId')) {
            return ContactResource::collection(Contact::where('client_id', $clientId)->latest()->paginate(10));
        }
        return ContactResource::collection(Contact::latest()->paginate(10));
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
            'first_name'  =>  'required|string|max:191',
            'last_name'  =>  'required|string|max:191',
            'email'  =>  'required|string|max:191|email|unique:contacts',
        ]);

        $request['name'] = $request['first_name'].' '.$request['middle'].' '.$request['last_name'];

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
            'first_name'  =>  'required|string|max:191',
            'last_name'  =>  'required|string|max:191',
            'email'  =>  'required|string|max:191|email|unique:contacts',
        ]);

        $request['name'] = $request['first_name'].' '.$request['middle'].' '.$request['last_name'];

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
