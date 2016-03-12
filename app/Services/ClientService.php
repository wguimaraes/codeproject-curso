<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Services;

use \CodeProject\Repositories\ClientRepository;
use \CodeProject\Validators\ClientValidator;
use \Prettus\Validator\Exceptions\ValidatorException;

/**
 * Description of ClientService
 *
 * @author William
 */
class ClientService {
    
    protected $repository;
    
    protected $validator;


    public function __construct(ClientRepository $repository, ClientValidator $validator) {
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
                'message' => 'Client ' . $id . ' has ben deleted.'
                ];
        }else{
            return [
                'error' => true,
                'message' => 'Error on delete client ' . $id . '.'
            ];
        }
    }
    
}
