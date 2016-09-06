<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use \CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;

class ProjectController extends Controller
{
    
    private $repository;
    private $service;
    
    public function __construct(ProjectRepository $repository, ProjectService $service) {
        $this->repository = $repository;
        $this->service = $service;
        $this->middleware('check-project-owner', ['except' => ['store', 'show', 'index']]);
        $this->middleware('check-project-permission', ['except' => ['index', 'store', 'update', 'destroy']]);
    }
    
    public function index(){
        return $this->service->findWhere();
    }
    
    public function store(Request $request){
        return $this->service->create($request->all());
    }
    
    public function show($id){
        return $this->service->find($id);
    }
    
    public function destroy($id){
        if(!$this->service->checkOwnerId($id)){
            return ['error' => true, 'message' => 'Access forbidden'];
        }
        return $this->service->destroy($id);
    }
    
    public function update(Request $request, $id){
        if(!$this->service->checkOwnerId($id)){
            return ['error' => true, 'message' => 'Access forbidden'];
        }
        return $this->service->update($request->all(), $id);
    }
    
    public function findMembers($id){
        return $this->service->findMembers($id);
    }
    
    public function addMember($id, $memberId){
        return $this->service->addMember($id, $memberId);
    }
    
    public function removeMember($id, $memberId){
        return $this->service->removeMember($id, $memberId);
    }
}
