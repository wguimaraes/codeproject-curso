<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;

/**
 * Description of ProjectTransformer
 *
 * @author William
 */
class ProjectTransformer extends TransformerAbstract {
    
    protected $defaultIncludes = ['members'];
    
    public function transform(Project $project){
        return[
            'project_id' => $project->id,
            'project_name' => $project->name,
            'client_id' => $project->client_id,
            'owner_id' => $project->owner_id,
            'description' => $project->description,
            'progress' => $project->progress,
            'status' => $project->status,
            'due_date' => $project->due_date,
            'create_at' => $project->create_at,
            'update_at' => $project->update_at,
        ];
    }
    
    public function includeMembers(Project $project){
        return $this->collection($project->members, new ProjectMembersTransformer());
    }
    
}
