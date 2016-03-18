<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

/**
 * Description of ProjectNoteValidator
 *
 * @author William
 */
class ProjectNoteValidator extends LaravelValidator {
    protected $rules = [
        'project_id' => 'required|integer',
        'title' => 'required',
        'content' => 'required'
    ];
}
