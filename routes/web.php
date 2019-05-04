<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'api'], function () use ($router) {
  // []
  $router->group(['prefix' => 'user'], function () use ($router) {
    // $router->update('/me/', ['uses' => 'UserController@updateProfile']);
    
    $router->post('/me/favorites/', ['uses' => 'UserController@addNoteFavorite']);
    $router->delete('/me/favorites/{note_id}', ['uses' => 'UserController@removeNoteFavorite']);
    
    $router->post('/me/saved/', ['uses' => 'UserController@addNoteSaved']);
    $router->delete('/me/saved/{note_id}', ['uses' => 'UserController@removeNoteSaved']);
    
    
    $router->get('/{username}/', ['uses' => 'UserController@getOne']);

    $router->get('/{username}/notes', ['uses' => 'UserController@getNotes']);
    $router->get('/{username}/favorite/', ['uses' => 'UserController@getNotesFavorite']);
    $router->get('/{username}/saved/', ['uses' => 'UserController@getNotesSaved']);
  });

  // [x]
  $router->group(['prefix' => 'auth'], function () use ($router) {
    $router->get('/login-with-token/', ['uses' => 'AuthController@loginWithToken']);
    $router->post('/login-with-email/', ['uses' => 'AuthController@loginWithEmail']);
    $router->post('/login-with-username/', ['uses' => 'AuthController@loginWithUsername']);
    $router->post('/register/', ['uses' => 'AuthController@register']);
  });

  // [x]
  $router->group(['prefix' => 'institutions'], function () use ($router) {
    $router->get('/', ['uses' => 'InstitutionsController@getAll']);
    $router->post('/', ['uses' => 'InstitutionsController@createOne']);
    // $router->delete('/{institution_id}/', ['uses' => 'InstitutionsController@deleteOne']);
    // $router->get('/{institution_id}/', ['uses' => 'InstitutionsController@getOne']);
    // $router->patch('/{institution_id}/', ['uses' => 'InstitutionsController@updateOne']);
    $router->get('/{institution_id}/subjects/', ['uses' => 'InstitutionsController@getSubjects']);
  });

  // [x]
  $router->group(['prefix' => 'subjects'], function () use ($router) {
    $router->post('/', ['uses' => 'SubjectsController@createOne']);
    // $router->delete('/{subject_id}/', ['uses' => 'SubjectsController@deleteOne']);
    // $router->get('/{subject_id}/', ['uses' => 'SubjectsController@getOne']);
    // $router->patch('/{subject_id}/', ['uses' => 'SubjectsController@updateOne']);
  });
  
  // [x]
  $router->group(['prefix' => 'code_years'], function () use ($router) {
    $router->post('/', ['uses' => 'CodeYearsController@createOne']);
    $router->get('/', ['uses' => 'CodeYearsController@getAll']);
    // $router->get('/{code_year_id}/', ['uses' => 'CodeYearsController@getOne']);
  });
  
  // [x]
  $router->group(['prefix' => 'code_notes'], function () use ($router) {
    $router->post('/', ['uses' => 'CodeNotesController@createOne']);
    $router->get('/', ['uses' => 'CodeNotesController@getAll']);
    // $router->get('/{code_note_id}/', ['uses' => 'CodeNotesController@getOne']);
  });

  // [x]
  $router->group(['prefix' => 'notes'], function () use ($router) {
    $router->get('/', ['uses' => 'NotesController@getAll']);
    $router->post('/', ['uses' => 'NotesController@createOne']);
    $router->get('/{note_id}/', ['uses' => 'NotesController@getOne']);
    // $router->delete('/{note_id}/', ['uses' => 'NotesController@deleteOne']);
  });
});

