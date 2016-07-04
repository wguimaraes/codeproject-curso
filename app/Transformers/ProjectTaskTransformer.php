<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectTask;
use League\Fractal\TransformerAbstract;

/**
 * Description of ProjectTransformer
 *
 * @author William
 */
class ProjectTaskTransformer extends TransformerAbstract {
    
    public function transform(ProjectTask $task){
        return[
            'task_id' => $task->id,
            'project_id' => $task->project_id,
            'task_name' => $task->name,
            'start_date' => $task->start_date,
            'due_date' => $task->due_date,
            'status' => $task->status,
            'create_at' => $task->create_at,
            'update_at' => $task->update_at,
        ];
    }
    
}
