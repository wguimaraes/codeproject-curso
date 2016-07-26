<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Repositories;

use CodeProject\Entities\User;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Description of UserRepositoryEloquent
 *
 * @author William
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository {
    
    public function model(){
        return User::class;
    }
    
}
