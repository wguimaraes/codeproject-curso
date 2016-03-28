<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Services;

use \CodeProject\Repositories\ProjectRepository;
use \CodeProject\Validators\ProjectValidator;
use \Prettus\Validator\Exceptions\ValidatorException;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Database\QueryException;
use \Illuminate\Http\Exception;

use \CodeProject\Entities\ProjectMember;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;

/**
 * Description of ProjectService
 *
 * @author William
 */
class ProjectService {
    
    protected $repository;
    protected $validator;
    protected $fileSystem;
    protected $storage;

    public function __construct(ProjectRepository $repository, ProjectValidator $validator, Filesystem $fileSystem, Storage $storage) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->fileSystem = $fileSystem;
        $this->storage = $storage;
    }
    
    public function find($id){
        try{
            return $this->repository->with(['client', 'user'])->find($id);
        }catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Project ' . $id . ' not found.'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'An error occurred on searching project ' . $id . '.'];
        }
    }
    
    public function create(array $data){
        try{
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        }catch(ValidatorException $e){
            return ['error' => true, 'message' => $e->getMessageBag()];
        }catch(QueryException $e){
            return ['error' => true, 'message' => 'Dependency fields have invalid values for project'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'Error on create project.'];
        }
        
    }
    
    public function update(array $data, $id){
        
        try{
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        }catch(ValidatorException $e){
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }catch(QueryException $e){
            return ['error' => true, 'message' => 'Dependency fields have invalid values for project ' . $id . ''];
        }catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Project ' . $id . ' not found.'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'An error occurred while updating project.'];
        }
    }
    
    public function destroy($id){
        try{
            $this->repository->delete($id);
            return ['message' => 'Project ' . $id . ' has ben deleted.'];
        }catch(QueryException $e){
            return ['error' => true, 'message' => 'Project ' . $id . ' can\'t be deleted because has registry dependences'];
        }catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Project id: ' . $id . ' not found.'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'Error on delete project ' . $id . '.'];
        }
    }
    
    public function createFile(array $data){
        try{
            $project = $this->repository->skipPresenter()->find($data['project_id']);
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
    
    public function findMembers($projectId){
        try{
            $project = $this->repository->skipPresenter()->find($projectId);
            if($project){
                return $project->members;
            }else{
                return ['error' => true, 'message' => 'Project ' . $projectId . ' not found.'];
            }
        }catch(QueryException $e){
            return ['error' => true, 'message' => 'An error occurred on search members of project ' . $projectId . '.'];
        }catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Project id: ' . $projectId . ' not found.'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'Error on find members of project ' . $projectId   . '.'];
        }
    }
    
    public function addMember(array $data){
        try{
            $project = $this->repository->skipPresenter()->find($data['project_id']);
            if($project){
                return $project->members()->create($data);
                $projectMember = new ProjectMember();
                return $projectMember->create($data);
            }else{
                return ['error' => true, 'message' => 'Project ' . $data['project_id'] . ' not found.'];
            }
        }catch(QueryException $e){
            return ['error' => true, 'message' => 'An error occurred on add member to project ' . $data['project_id'] . '.'];
            return ['error' => true, 'message' => $e];
        }catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Project id: ' . $data['project_id'] . ' not found.'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'Error on add members to project ' . $data['project_id'] . '.'];
        }
    }
    
    public function removeMember($projectId, $memberId){
        
    }
    
}
