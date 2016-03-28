<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use \CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectTaskService;

class ProjectTaskController extends Controller
{
    
    private $repository;
    private $service;
    
    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service) {
        $this->repository = $repository;
        $this->service = $service;
    }
    
    
    public function index($id){
        return $this->repository->findWhere(['project_id' => $id]);
    }
    
    public function store(Request $request){
        return $this->service->create($request->all());
    }
    
    public function show($id, $taskId){
        return $this->service->findWhere($id, $taskId);
    }
    
    public function destroy($id, $noteId){
        return $this->service->destroy($noteId);
    }
    
    public function update(Request $request, $id, $taskId){
        return $this->service->update($request->all(), $taskId);
    }
}
