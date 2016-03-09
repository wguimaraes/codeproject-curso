<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use CodeProject\Client;

class ClientController extends Controller
{
    public function index(){
        return Client::all();
    }
    
    public function store(Request $request){
        return Client::create($request->all());
    }
    
    public function show($id){
        return Client::find($id);
    }
    
    public function destroy($id){
        Client::destroy($id);
    }
    
    public function update(Request $request, $id){
        $client = Client::find($id);
        if($client){
            $client->name           = $request->name;
            $client->responsible    = $request->responsible;
            $client->email          = $request->email;
            $client->phone          = $request->phone;
            $client->address        = $request->address;
            $client->obs            = $request->obs;
            $client->save();
        }
    }
}
