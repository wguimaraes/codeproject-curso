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

/**
 * Description of ProjectService
 *
 * @author William
 */
class ProjectService {
    
    protected $repository;
    
    protected $validator;


    public function __construct(ProjectRepository $repository, ProjectValidator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }
    
    public function create(array $data){
        
        try{
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        }catch(ValidatorException $e){
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
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
        }
    }
    
    public function destroy($id){
        if($this->repository->delete($id)){
            return [
                'message' => 'Project ' . $id . ' has ben deleted.'
                ];
        }else{
            return [
                'error' => true,
                'message' => 'Error on delete project ' . $id . '.'
            ];
        }
    }
    
}
