<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Services;

use \CodeProject\Repositories\ProjectTaskRepository;
use \CodeProject\Validators\ProjectTaskValidator;
use \Prettus\Validator\Exceptions\ValidatorException;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Database\QueryException;
use \Illuminate\Http\Exception;

/**
 * Description of ProjectNoteService
 *
 * @author William
 */
class ProjectTaskService {
    
    protected $repository;
    
    protected $validator;


    public function __construct(ProjectTaskRepository $repository, ProjectTaskValidator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }
    
    public function findWhere($id, $noteId){
        try{
            $projectNote = $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
            if(sizeof($projectNote) > 0){
                return $projectNote;
            }else{
                return ['error' => true, 'message' => 'Project task ' . $noteId . ' not found.'];
            }
        }catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Project task not ' . $noteId . ' found.'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'An error occurred on searching project ' . $noteId . ' .'];
        }
    }
    
    public function create(array $data){
        
        try{
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        }catch(ValidatorException $e){
            return ['error' => true, 'message' => $e->getMessageBag()];
        }catch(QueryException $e){
            return ['error' => true, 'message' => 'Dependency fields have invalid values for project task'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'Error on create project task.'];
        }
        
    }
    
    public function update(array $data, $id){
        
        try{
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        }catch(ValidatorException $e){
            return ['error' => true, 'message' => $e->getMessageBag()];
        }catch(QueryException $e){
            return ['error' => true, 'message' => 'Dependency fields have invalid values for project task ' . $id . ''];
        }catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Project task ' . $id . ' not found.'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'An error occurred while updating project task.'];
        }
    }
    
    public function destroy($id){
        try{
            $this->repository->delete($id);
            return ['message' => 'Project task ' . $id . ' has ben deleted.'];
        }catch(QueryException $e){
            return ['error' => true, 'message' => 'Project task ' . $id . ' can\'t be deleted because the query has errors'];
        }catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Project task id: ' . $id . ' not found.'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'Error on delete project task ' . $id . '.'];
        }
    }
    
}
