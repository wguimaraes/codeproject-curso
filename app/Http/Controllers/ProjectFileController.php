<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use \CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;

class ProjectFileController extends Controller
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
        $file = $request->file('file');
        if($file){
            $data['name'] = $request->project_id . '_' . $request->name;
            $data['description'] = $request->description;
            $data['project_id'] = $request->project_id;
            $data['extension'] = $file->getClientOriginalExtension();
            $data['file'] = $file;
            return $this->service->createFile($data);
        }else{
            return ['error' => true, 'message' => 'No file to storage.'];
        }
    }
    
    public function show($id){
        if(!$this->projectViewPermission($id)){
            return ['error' => true, 'message' => 'Access forbidden'];
        }
        return $this->service->find($id);
    }
    
    public function destroy($projectId, $fileId){
        if(!$this->checkOwnerId($projectId)){
            return ['error' => true, 'message' => 'Access forbidden'];
        }
        return $this->service->deleteFile($projectId, $fileId);
    }
}
