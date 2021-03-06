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

/**
 * Description of ProjectService
 *
 * @author William
 */
class ProjectService {
    
    protected $repository;
    protected $validator;
    protected $userId;

    public function __construct(ProjectRepository $repository, ProjectValidator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->userId = \Authorizer::getResourceOwnerId();
    }
    
    public function find($id){
        try{
            return $this->repository->find($id);
        }catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Project file' . $id . ' not found.'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'An error occurred on searching project file ' . $id . '.'];
        }
    }
    
    public function findWhere(){
    	//return $this->repository->findWhere(['owner_id' => $this->userId]);
    	return $this->repository->findWithOwnerAndMember($this->userId);
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
    
    
    
    public function findMembers($projectId){
        $project = $this->repository->skipPresenter()->find($projectId);
        return $project->members;
    }
    
    public function addMember($projectId, $memberId){
        try{
            $project = $this->repository->skipPresenter()->find($projectId);
            if(!$this->isMember($projectId, $memberId)){
                $project->members()->attach($memberId);
                return ['message' => 'Member ' . $memberId . ' has added to project ' . $projectId . '.'];
            }else{
                return ['error' => true, 'message' => 'Member ' . $memberId . ' already related to project ' . $projectId . '.'];
            }
        }catch(QueryException $e){
            return ['error' => true, 'message' => 'An error occurred on add member ' . $memberId . ' to project ' . $projectId . '.'];
        }catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Project id: ' . $projectId . ' not found.'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'Error on add members to project ' . $projectId . '.'];
        }
    }
    
    public function removeMember($projectId, $memberId){
        try{
            $project = $this->repository->skipPresenter()->find($projectId);
            if($this->isMember($projectId, $memberId)){
                $project->members()->detach($memberId);
                return ['message' => 'Member ' . $memberId . ' is removed to project ' . $projectId . '.'];
            }else{
                return ['error' => true, 'message' => 'Member ' . $memberId . ' not found in project ' . $projectId . '.'];
            }
        }catch(QueryException $e){
            return ['error' => true, 'message' => 'An error occurred on add member ' . $memberId . ' to project ' . $projectId . '.'];
        }catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Project id: ' . $projectId . ' not found.'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'Error on add members to project ' . $projectId . '.'];
        }
    }
    
    private function isMember($projectId, $memberId){
        $project = $this->repository->skipPresenter()->find($projectId);
        return $project->members->find($memberId);
    }
    
    public function checkOwnerId($id){
    	return $this->repository->isOwner($id, $this->userId);
    }
    
    public function checkProjectMember($id){
    	return $this->repository->hasMember($id, $this->userId);
    }
    
    public function projectViewPermission($id){
    	if($this->checkOwnerId($id) || $this->checkProjectMember($id)){
    		return true;
    	}else{
    		return false;
    	}
    }
    
}
