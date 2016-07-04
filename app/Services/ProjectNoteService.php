<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Services;

use \CodeProject\Repositories\ProjectNoteRepository;
use \CodeProject\Validators\ProjectNoteValidator;
use \Prettus\Validator\Exceptions\ValidatorException;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Database\QueryException;
use \Illuminate\Http\Exception;

/**
 * Description of ProjectNoteService
 *
 * @author William
 */
class ProjectNoteService {
    
    protected $repository;
    
    protected $validator;


    public function __construct(ProjectNoteRepository $repository, ProjectNoteValidator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }
    
    public function findWhere($id, $noteId){
        try{
            $projectNote = $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
            if(sizeof($projectNote) > 0){
                return $projectNote;
            }else{
                return ['error' => true, 'message' => 'Project note ' . $noteId . ' not found.'];
            }
        }catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Project note not ' . $noteId . ' found.'];
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
            return ['error' => true, 'message' => 'Dependency fields have invalid values for project note'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'Error on create project note.'];
        }
        
    }
    
    public function update(array $data, $id){
        
        try{
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        }catch(ValidatorException $e){
            return ['error' => true, 'message' => $e->getMessageBag()];
        }catch(QueryException $e){
            return ['error' => true, 'message' => 'Dependency fields have invalid values for project note ' . $id . ''];
        }catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Project note not ' . $id . ' found.'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'An error occurred while updating project note.'];
        }
    }
    
    public function destroy($id){
        try{
            $this->repository->delete($id);
            return ['message' => 'Project note ' . $id . ' has ben deleted.'];
        }catch(QueryException $e){
            return ['error' => true, 'message' => 'Project note ' . $id . ' can\'t be deleted because the query has errors'];
        }catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Project note id: ' . $id . ' not found.'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'Error on delete project note ' . $id . '.'];
        }
    }
    
}
