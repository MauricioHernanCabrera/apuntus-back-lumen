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

  $router->group(['prefix' => 'institutions'], function () use ($router) {
    // Free
    $router->get('/', ['uses' => 'InstitutionsController@getAll']);
    $router->get('/{institution_id:\d+}/subjects/', ['uses' => 'InstitutionsController@getSubjects']);
    
    // User registers
    $router->post('/', [
      'middleware' => 'auth',
      'uses' => 'InstitutionsController@createOne'
    ]);
  });

  $router->group(['prefix' => 'subjects'], function () use ($router) {
    // User registers
    $router->post('/', [
      'middleware' => 'auth',
      'uses' => 'SubjectsController@createOne'
    ]);
  });

  $router->group(['prefix' => 'code_notes'], function () use ($router) {
    // User registers
    $router->get('/', [
      'middleware' => 'auth',
      'uses' => 'CodeNotesController@getAll'
    ]);
  });
    
    
  $router->group(['prefix' => 'code_years'], function () use ($router) {
    // User registers
    $router->get('/', [
      'middleware' => 'auth',
      'uses' => 'CodeYearsController@getAll'
    ]);
  });
    
  $router->group(['prefix' => 'notes'], function () use ($router) {
    // Free
    $router->get('/', ['uses' => 'NotesController@getAll']);
    $router->get('/{note_id:\d+}/', ['uses' => 'NotesController@getOne']);
    
    // User registers
    $router->post('/', [
      'middleware' => 'auth',
      'uses' => 'NotesController@createOne'
    ]);

    $router->delete('/{note_id:\d+}/', [
      'middleware' => 'auth',
      'uses' => 'NotesController@deleteOne'
    ]);
    
  });

  $router->group(['prefix' => 'auth'], function () use ($router) {
    // Free
    $router->get('/login-with-token/', ['uses' => 'AuthController@loginWithToken']);
    $router->post('/login-with-email/', ['uses' => 'AuthController@loginWithEmail']);
    $router->post('/login-with-username/', ['uses' => 'AuthController@loginWithUsername']);
    $router->post('/register/', ['uses' => 'AuthController@register']);
  });



  $router->group(['prefix' => 'user'], function () use ($router) {
    // $router->update('/me/', ['uses' => 'UserController@updateProfile']);
    
    $router->post('/me/favorites/', ['uses' => 'UserController@addNoteFavorite']);
    $router->delete('/me/favorites/{note_id:\d+}', ['uses' => 'UserController@removeNoteFavorite']);
    
    $router->post('/me/saved/', ['uses' => 'UserController@addNoteSaved']);
    $router->delete('/me/saved/{note_id:\d+}', ['uses' => 'UserController@removeNoteSaved']);
    
    
    $router->get('/{username:[a-zA-Z0-9\-\ñ\Ñ\.\_]}/', ['uses' => 'UserController@getOne']);

    $router->get('/{username:[a-zA-Z0-9\-\ñ\Ñ\.\_]}/notes', ['uses' => 'UserController@getNotes']);
    $router->get('/{username:[a-zA-Z0-9\-\ñ\Ñ\.\_]}/favorite/', ['uses' => 'UserController@getNotesFavorite']);
    $router->get('/{username:[a-zA-Z0-9\-\ñ\Ñ\.\_]}/saved/', ['uses' => 'UserController@getNotesSaved']);
  });
});

