<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Services\UserService;

class UserController extends Controller
{
	
	protected $service;
	
	public function __construct(UserService $service){
		$this->service = $service;
	}
	
    public function authenticated(){
    	$userId = \Authorizer::getResourceOwnerId();
    	return $this->service->find($userId);
	}
}
