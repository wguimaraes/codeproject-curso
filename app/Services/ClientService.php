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
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Database\QueryException;
use \Illuminate\Http\Exception;

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
    
    public function find($id){
        try{
            return $this->repository->find($id);
        }catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Client ' . $id . ' not found.'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'An error occurred on searching client ' . $id . '.'];
        }
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
        }catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Client ' . $id . ' not found.'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'An error occurred while updating client.'];
        }
    }
    
    public function destroy($id){
        try{
            $this->repository->delete($id);
            return [
                'message' => 'Client ' . $id . ' has ben deleted.'
                ];
        }catch(QueryException $e){
            return ['error' => true, 'message' => 'Client ' . $id . ' can\'t be deleted because has registry dependences'];
        }catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'Client id: ' . $id . ' not found.'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'Error on delete client ' . $id . '.'];
        }
    }
    
}
