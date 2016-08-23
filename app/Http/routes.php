<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('app');
    });
    
    Route::post('oauth/access_token', function(){
        return Response::json(Authorizer::issueAccessToken());
    });
    
    Route::group(['middleware' => 'oauth'], function(){
        
        Route::resource('client', 'ClientController', ['except' => ['create', 'edit']]);
        Route::get('user/authenticated', 'UserController@authenticated');
        /*
         * O método Route::resource() equivale a agrupar todas as rotas do controller informado e 
         * permitir que essas executem métodos de get post, delete, update, etc..
         * Funções de formulário que não estamos utilziando (create e edit), estão sendo excluídas 
         * das requisições por não existirem em nosso controller
         */
//        Route::get('client', ['middleware' => 'oauth', 'uses' => 'ClientController@index']);
//        Route::post('client', 'ClientController@store');
//        Route::get('client/{id}', 'ClientController@show');
//        Route::delete('client/{id}', 'ClientController@destroy');
//        Route::put('client/{id}', 'ClientController@update');

        Route::resource('project', 'ProjectController', ['except' => ['create', 'edit']]);
        
        Route::group(['prefix' => 'project'], function(){     
            Route::get('{id}/notes', 'ProjectNoteController@index');
            Route::post('{id}/notes', 'ProjectNoteController@store');
            Route::get('{id}/notes/{noteId}', 'ProjectNoteController@show');
            Route::put('{id}/notes/{noteId}', 'ProjectNoteController@update');
            Route::delete('{id}/notes/{noteId}', 'ProjectNoteController@destroy');
            
            Route::get('{id}/files', 'ProjectFileController@index');
            Route::post('{id}/files', 'ProjectFileController@store');
            Route::put('{id}/files/{fileId}', 'ProjectFileController@update');
            Route::delete('{id}/files/{fileId}', 'ProjectFileController@destroy');
            Route::get('files/{fileId}', 'ProjectFileController@show');
            Route::get('files/{fileId}/download', 'ProjectFileeController@showFile');
            
            Route::get('{id}/tasks', 'ProjectTaskController@index');
            Route::post('{id}/tasks', 'ProjectTaskController@store');
            Route::get('{id}/tasks/{taskId}', 'ProjectTaskController@show');
            Route::put('{id}/tasks/{taskId}', 'ProjectTaskController@update');
            Route::delete('{id}/tasks/{taskId}', 'ProjectTaskController@destroy');
            
            Route::get('{id}/members', 'ProjectController@findMembers');
            Route::post('{id}/members/{memberId}', 'ProjectController@addMember');
            Route::delete('{id}/members/{memberId}', 'ProjectController@removeMember');
            
            Route::post('{id}/file', 'ProjectFileController@store');
            Route::delete('{id}/file/{fileId}', 'ProjectFileController@destroy');
        });
//        Route::get('project/{id}/notes', 'ProjectNoteController@index');
//        Route::post('project/{id}/notes', 'ProjectNoteController@store');
//        Route::get('project/{id}/notes/{noteId}', 'ProjectNoteController@show');
//        Route::put('project/{id}/notes/{noteId}', 'ProjectNoteController@update');
//        Route::delete('project/{id}/notes/{noteId}', 'ProjectNoteController@destroy');

//        Route::get('project', 'ProjectController@index');
//        Route::post('project', 'ProjectController@store');
//        Route::get('project/{id}', 'ProjectController@show');
//        Route::delete('project/{id}', 'ProjectController@destroy');
//        Route::put('project/{id}', 'ProjectController@update'); 
    });
    
});
