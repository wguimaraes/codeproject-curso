<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use \CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;

class ProjectController extends Controller
{
    
    private $repository;
    private $service;
    private $userId;
    
    public function __construct(ProjectRepository $repository, ProjectService $service) {
        $this->repository = $repository;
        $this->service = $service;
        $this->userId = \Authorizer::getResourceOwnerId();
    }
    
    private function checkOwnerId($id){
        return $this->repository->isOwner($id, $this->userId);
    }
    
    private function checkProjectMember($id){
        return $this->repository->hasMember($id, $this->userId);
    }
    
    private function projectViewPermission($id){
        if($this->checkOwnerId($id) || $this->checkProjectMember($id)){
            return true;
        }else{
            return false;
        }
    }
    
    public function index(){
        return $this->repository->findWhere(['owner_id' => $this->userId]);
    }
    
    public function store(Request $request){
        return $this->service->create($request->all());
    }
    
    public function show($id){
        if(!$this->projectViewPermission($id)){
            return ['error' => true, 'message' => 'Access forbidden'];
        }
        return $this->service->find($id);
    }
    
    public function destroy($id){
        if(!$this->checkOwnerId($id)){
            return ['error' => true, 'message' => 'Access forbidden'];
        }
        return $this->service->destroy($id);
    }
    
    public function update(Request $request, $id){
        if(!$this->checkOwnerId($id)){
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
