<?php

namespace App\Http\Controllers\API\Contacts;

use App\Model\Contacts\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Client::latest()->paginate(10);
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
            'name'  =>  'required|string|max:191|unique:clients',
            'phone' =>  'required|string|max:191|unique:clients',
            'website' =>  'required|string|max:191',
            'industry' =>  'required|string|max:191',
        ]);

        return Client::create([
            'name'  =>  $request['name'],
            'website' =>  $request['website'],
            'industry' =>  $request['industry'],
            'revenue' =>  $request['revenue'],
            'description' =>  $request['description'],
            'phone' =>  $request['phone'],
            'street1' =>  $request['street1'],
            'street2' =>  $request['street2'],
            'city' =>  $request['city'],
            'state' =>  $request['state'],
            'zip' =>  $request['zip'],
            'country' =>  $request['country'],
            'notes' =>  $request['notes']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Contacts\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::findOrFail($id);

        return response()->json([
            'data' => $client
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Contacts\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $this->validate($request, [
            'name'  =>  'required|string|max:191|unique:clients,name,'.$client->id,
            'phone' =>  'required|string|max:191|unique:clients,phone,'.$client->id,
            'website' =>  'required|string|max:191',
            'industry' =>  'required|string|max:191',
        ]);

        $client->update($request->all());

        return response()->json(['message' => __('messages.update_success')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Contacts\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client = Client::findOrFail($client);

        // Delete the client
        $client->withTrashed();
        return ['message' => 'User Deleted'];
    }

    public function getClients() {
        $data = Client::select('id', 'name')->get();
        return response()->json([
            'data' => $data
        ]);
    }
}
