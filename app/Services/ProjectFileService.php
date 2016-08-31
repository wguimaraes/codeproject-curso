<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Services;

use \CodeProject\Repositories\ProjectFileRepository;
use \CodeProject\Repositories\ProjectRepository;
use \CodeProject\Validators\ProjectFileValidator;
use \Prettus\Validator\Exceptions\ValidatorException;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Database\QueryException;
use \Illuminate\Http\Exception;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;

/**
 * Description of ProjectFileService
 *
 * @author William
 */
class ProjectFileService {
    
    protected $repository;
    protected $validator;
    protected $projectRepository;
    protected $fileSystem;
    protected $storage;
    private $userId;

    public function __construct(ProjectFileRepository $repository, ProjectRepository $projectRepository, 
    		ProjectFileValidator $validator, Filesystem $fileSystem, Storage $storage) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->projectRepository = $projectRepository;
        $this->fileSystem = $fileSystem;
        $this->storage = $storage;
        $this->userId = \Authorizer::getResourceOwnerId();
    }
    
    public function find($id){
    	try{
    		return $this->repository->find($id);
    	}catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Project file ' . $id . ' not found.'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'An error occurred on searching project ' . $id . ' .'];
        }
    }
    
    public function findWhere($id, $fileId){
        try{
            $projectFile = $this->repository->findWhere(['project_id' => $id, 'id' => $fileId]);
            if(sizeof($projectFile) > 0){
                return $projectFile['data'][0];
            }else{
                return ['error' => true, 'message' => 'Project file ' . $fileId . ' not found.'];
            }
        }catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Project file not ' . $fileId . ' found.'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'An error occurred on searching project ' . $fileId . ' .'];
        }
    }
    
	public function create(array $data){
    	try{
    		$project = $this->projectRepository->skipPresenter()->find($data['project_id']);
    		$projectFile = $project->files()->create($data);
    		$this->storage->put($projectFile->getFileName(), $this->fileSystem->get($data['file']));
    		return ['message' => 'File was uploaded!'];
    	}catch(QueryException $e){
    		return ['error' => true, 'message' => 'An error occurred on upload file.'];
    	}catch(ModelNotFoundException $e){
    		return ['error' => true, 'message' => 'Project id: ' . $id . ' not found.'];
    	}catch(Exception $e){
    		return ['error' => true, 'message' => 'Error on upload file to project ' . $id . '.'];
    	}
    }
    
    public function update(array $data, $id){
        
        try{
        	$this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        }catch(ValidatorException $e){
            return ['error' => true, 'message' => $e->getMessageBag()];
        }catch(QueryException $e){
            return ['error' => true, 'message' => 'Dependency fields have invalid values for project file ' . $id . ''];
        }catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Project file not ' . $id . ' found.'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'An error occurred while updating project file.'];
        }
    }
    
    public function deleteFile($projectId, $fileId){
    	try{
    		$projectFile = $this->repository->skipPresenter()->find($fileId);
    		if($projectFile){
    			if($projectFile){
    				if($this->storage->exists($projectFile->getFileName())){
    					$this->storage->delete($projectFile->getFileName());
    				}
    				$projectFile->delete();
    				return ['message' => 'File ' . $projectFile->id . '.' . $projectFile->extension . ' was deleted!'];
    			}
    		}else{
    			return ['error' => true, 'message' => 'File ' . $fileId . ' not found in project ' . $projectId];
    		}
    	}catch(QueryException $e){
    		return ['error' => true, 'message' => 'An error occurred on delete file.'];
    	}catch(ModelNotFoundException $e){
    		return ['error' => true, 'message' => 'Project id: ' . $projectId . ' not found.'];
    	}catch(Exception $e){
    		return ['error' => true, 'message' => 'Error on delete file to project ' . $projectId . '.'];
    	}
    }
    
    public function checkOwnerId($fileId){
    	$project_id = $this->repository->skipPresenter()->find($fileId)->project_id;
    	return $this->projectRepository->isOwner($project_id, $this->userId);
    }
    
    public function checkProjectMember($fileId){
    	$project_id = $this->repository->skipPresenter()->find($fileId)->project_id;
    	return $this->projectRepository->hasMember($project_id, $this->userId);
    }
    
    public function projectViewPermission($fileId){
    	if($this->checkOwnerId($fileId) || $this->checkProjectMember($fileId)){
    		return true;
    	}else{
    		return false;
    	}
    }
    
    public function getFilePath($id){
    	$projectFile = $this->repository->skipPresenter()->find($id);
    	return $this->getBaseUrl($projectFile);
    }
    
    public function getFileName($fileId){
    	$projectFile = $this->repository->find($fileId);
    	return $projectFile->getFileName();
    }
    
    private function getBaseUrl($projectFile){
    	switch($this->storage->getDefaultDriver()){
    		case 'local':
    			return $this->storage->getDriver()->getAdapter()->getPathPrefix() . '/' . 
    			$projectFile->getFileName();
    			break;
    	}
    }
    
}
