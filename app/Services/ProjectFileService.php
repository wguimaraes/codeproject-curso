<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Services;

use \CodeProject\Repositories\ProjectFileRepository;
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
    protected $projectRepository;
    protected $fileSystem;
    protected $storage;

    public function __construct(ProjectFileRepository $repository, ProjectRepository $projectRepository, Filesystem $fileSystem, Storage $storage) {
        $this->repository = $repository;
        $this->projectRepository = $projectRepository;
        $this->fileSystem = $fileSystem;
        $this->storage = $storage;
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
            return $this->repository->create($data);
        }catch(ValidatorException $e){
            return ['error' => true, 'message' => $e->getMessageBag()];
        }catch(QueryException $e){
            return ['error' => true, 'message' => 'Dependency fields have invalid values for project file'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'Error on create project file.'];
        }
        
    }
    
    public function update(array $data, $id){
        
        try{
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
    
    public function destroy($id){
        try{
            $this->repository->delete($id);
            return ['message' => 'Project file ' . $id . ' has ben deleted.'];
        }catch(QueryException $e){
            return ['error' => true, 'message' => 'Project file ' . $id . ' can\'t be deleted because the query has errors'];
        }catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Project file id: ' . $id . ' not found.'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'Error on delete project file ' . $id . '.'];
        }
    }
    
    public function createFile(array $data){
    	try{
    		$project = $this->projectRepository->skipPresenter()->find($data['project_id']);
    		$projectFile = $project->files()->create($data);
    		$this->storage->put($projectFile->name . '.' . $data['extension'], $this->fileSystem->get($data['file']));
    		return ['message' => 'File was uploaded!'];
    	}catch(QueryException $e){
    		return ['error' => true, 'message' => 'An error occurred on upload file.'];
    	}catch(ModelNotFoundException $e){
    		return ['error' => true, 'message' => 'Project id: ' . $id . ' not found.'];
    	}catch(Exception $e){
    		return ['error' => true, 'message' => 'Error on upload file to project ' . $id . '.'];
    	}
    }
    
    public function deleteFile($projectId, $fileId){
    	try{
    		$project = $this->projectRepository->skipPresenter()->find($projectId);
    		if($project){
    			$projectFile = $project->files()->find($fileId);
    			if($projectFile){
    				$this->storage->delete($projectFile->name . '.' . $projectFile->extension);
    				$project->files()->delete($fileId);
    				return ['message' => 'File ' . $projectFile->name . '.' . $projectFile->extension . ' was deleted!'];
    			}else{
    				return ['error' => true, 'message' => 'File ' . $fileId . ' not found in project ' . $projectId];
    			}
    		}else{
    			return ['error' => true, 'message' => 'Project' . $projectId . ' not found'];
    		}
    	}catch(QueryException $e){
    		return ['error' => true, 'message' => 'An error occurred on delete file.'];
    	}catch(ModelNotFoundException $e){
    		return ['error' => true, 'message' => 'Project id: ' . $projectId . ' not found.'];
    	}catch(Exception $e){
    		return ['error' => true, 'message' => 'Error on delete file to project ' . $projectId . '.'];
    	}
    }
    
}
