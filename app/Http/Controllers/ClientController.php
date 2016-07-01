<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use \CodeProject\Repositories\ClientRepository;
use CodeProject\Services\ClientService;

class ClientController extends Controller
{
    
    private $repository;
    private $service;
    
    public function __construct(ClientRepository $repository, ClientService $service) {
        $this->repository = $repository;
        $this->service = $service;
    }
    
    
    public function index(){
        return $this->repository->skipPresenter()->all();
    }
    
    public function store(Request $request){
        return $this->service->create($request->all());
    }
    
    public function show($id){
        return $this->service->find($id);
    }
    
    public function destroy($id){
        return $this->service->destroy($id);
    }
    
    public function update(Request $request, $id){
        return $this->service->update($request->all(), $id);
    }
}
