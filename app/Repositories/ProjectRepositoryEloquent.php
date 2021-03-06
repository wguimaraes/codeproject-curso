<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Repositories;

use \CodeProject\Entities\Project;
use \Prettus\Repository\Eloquent\BaseRepository;
use \CodeProject\Presenters\ProjectPresenter;

/**
 * Description of ProjectRepositoryEloquent
 *
 * @author William
 */
class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository {
	
    public function model(){
        return Project::class;
    }
    
    public function findWithOwnerAndMember($userId){
    	return $this->scopeQuery(function($query) use ($userId){
    		return $query->leftJoin('project_members', 'project_members.project_id', '=', 'projects.id')
    			  ->where('project_members.member_id', '=', $userId)
    			  ->orWhere('projects.owner_id', '=', $userId);
    	})->all(['projects.*']);
    }
    
    public function isOwner($projectId, $userId){
        if(count($this->skipPresenter()->findWhere(['id' => $projectId, 'owner_id' => $userId]))){
            return true;
        }else{
            return false;
        }
    }
    
    public function hasMember($projectId, $memberId){
        $project = $this->find($projectId);
        
        foreach($project->members as $member){
            if($member->id == $memberId){
                return true;
            }
        }
        
        return false;
    }
    
    public function presenter(){
        return ProjectPresenter::class;
    }
}
