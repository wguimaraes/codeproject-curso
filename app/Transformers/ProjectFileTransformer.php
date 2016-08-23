<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectFile;
use League\Fractal\TransformerAbstract;

/**
 * Description of ProjectTransformer
 *
 * @author William
 */
class ProjectFileTransformer extends TransformerAbstract {
    
    public function transform(ProjectFile $file){
        return[
        	'project_id' => $file->project_id,
            'id' => $file->id,
            'name' => $file->name,
        	'extension' => $file->extension,
            'description' => $file->description
        ];
    }
    
}
