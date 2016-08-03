<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Repositories;

use CodeProject\Entities\Client;
use Prettus\Repository\Eloquent\BaseRepository;
use \CodeProject\Presenters\ClientPresenter;

/**
 * Description of ClientRepositoryEloquent
 *
 * @author William
 */
class ClientRepositoryEloquent extends BaseRepository implements ClientRepository {
	
	protected $fieldSearchable = [
			'name',
			'email'
	];
	
	public function boot(){
		$this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
	}
    
    public function model(){
        return Client::class;
    }

    public function presenter(){
        return ClientPresenter::class;
    }
    
}
