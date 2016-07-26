<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Services;

use \CodeProject\Repositories\UserRepository;
use \CodeProject\Validators\UserValidator;
use \Prettus\Validator\Exceptions\ValidatorException;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Database\QueryException;
use \Illuminate\Http\Exception;

/**
 * Description of UserService
 *
 * @author William
 */
class UserService {
    
    protected $repository;

    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }
    
    public function find($id){
        try{
            return $this->repository->find($id);
        }catch(ModelNotFoundException $e){
            return ['error' => true, 'message' => 'User ' . $id . ' not found.'];
        }catch(Exception $e){
            return ['error' => true, 'message' => 'An error occurred on searching user ' . $id . '.'];
        }
    }
    
}
