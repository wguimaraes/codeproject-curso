<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

/**
 * Description of ProjectTaskValidator
 *
 * @author William
 */
class ProjectTaskValidator extends LaravelValidator {
    protected $rules = [
    		ValidatorInterface::RULE_CREATE  => [
    				'project_id' => 'required|integer',
    				'name' => 'required'
    		],
    		ValidatorInterface::RULE_UPDATE => [
		        'project_id' => 'required|integer',
		        'name' => 'required',
		        'start_date' => 'required',
		        'due_date' => 'required',
		        'status' => 'required|integer'
    		]
    ];
}
