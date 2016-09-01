<?php

namespace CodeProject\Http\Middleware;

use Closure;
use CodeProject\Services\ProjectService;

class CheckProjectOwner
{
    
	protected $service;
	
	public function __construct(ProjectService $service){
		$this->service = $service;
	}
	
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
    public function handle($request, Closure $next)
    {
    	$projectId = isset($request->route('id')) ? $request->route('id') : $request->route('project');
    	
    	if(!$this->service->checkOwnerId($projectId)){
    		return ['error' => true, 'message' => 'Access forbidden'];
    	}
     	
        return $next($request);
    }
}
