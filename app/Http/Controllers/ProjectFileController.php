<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use \CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Services\ProjectFileService;

class ProjectFileController extends Controller
{
    
    private $repository;
    private $service;
    
    public function __construct(ProjectFileRepository $repository, ProjectFileService $service) {
        $this->repository = $repository;
        $this->service = $service;
    }
    
    public function index($projectId){
        return $this->repository->findWhere(['project_id' => $projectId]);
    }
    
    public function store(Request $request){
        $file = $request->file('file');
        if($file){
            $data['name'] = $request->name;
            $data['description'] = $request->description;
            $data['project_id'] = $request->project_id;
            $data['extension'] = $file->getClientOriginalExtension();
            $data['file'] = $file;
            return $this->service->create($data);
        }else{
            return ['error' => true, 'message' => 'No file to storage.'];
        }
    }
    
    public function update(Request $request, $fileId){
    	if($this->service->checkOwnerId($fileId) == false){
    		return ['error' => true, 'message' => 'Access forbidden'];
    	}
    	return $this->service->update($request->all(), $fileId);
    }
    
    public function show($fileId){
        if(!$this->service->projectViewPermission($fileId)){
            return ['error' => true, 'message' => 'Access forbidden'];
        }
        return $this->service->find($fileId);
    }
    
    public function destroy($projectId, $fileId){
        if(!$this->service->checkOwnerId($fileId)){
            return ['error' => true, 'message' => 'Access forbidden'];
        }
        return $this->service->deleteFile($projectId, $fileId);
    }
    
    public function showFile($fileId){
    	if(!$this->service->projectViewPermission($fileId)){
    		return ['error' => true, 'message' => 'Access forbidden'];
    	}
    	
    	$filePath		= $this->service->getFilePath($fileId);
    	$fileContent	= file_get_contents($filePath);
    	$file64			= base64_encode($fileContent);
    	
    	return [
    			'file' => $file64,
    			'size' => filesize($filePath),
    			'name' => $this->service->getFileName($fileId)
    	];
    }
}
