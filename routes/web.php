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
    // Free
    $router->get('/', [
      'uses' => 'CodeNotesController@getAll'
    ]);
  });
    
    
  $router->group(['prefix' => 'code_years'], function () use ($router) {
    // Free
    $router->get('/', [
      'uses' => 'CodeYearsController@getAll'
    ]);
  });
    
  $router->group(['prefix' => 'notes'], function () use ($router) {
    // Free
    $router->get('/', ['uses' => 'NotesController@getAll']);
    $router->get('/{note_id}/', ['uses' => 'NotesController@getOne']);
    
    // User registers
    $router->post('/', [
      'middleware' => 'auth',
      'uses' => 'NotesController@createOne'
    ]);
    $router->delete('/{note_id:\d+}/', [
      'middleware' => 'auth',
      'uses' => 'NotesController@deleteOne'
    ]);

    $router->post('/{note_id:\d+}/report', [
      'middleware' => 'auth',
      'uses' => 'NotesController@reportOne'
    ]);
  });

  $router->group(['prefix' => 'auth'], function () use ($router) {
    // Free
    $router->get('/login-with-token/', ['uses' => 'AuthController@loginWithToken']);
    $router->post('/login-with-email/', ['uses' => 'AuthController@loginWithEmail']);
    $router->post('/login-with-username/', ['uses' => 'AuthController@loginWithUsername']);
    $router->post('/register/', ['uses' => 'AuthController@register']);
    
    // $router->post('/password-reset/', ['uses' => 'AuthController@sendEmailResetPassword']);
    // $router->get('/password-reset/{secret_id}/', ['uses' => 'AuthController@resetPassword']);
  });

  $router->group(['prefix' => 'user'], function () use ($router) {
    // Register

    $router->group(['prefix' => 'me', 'middleware' => 'auth',], function () use ($router) {
      $router->patch('/', ['uses' => 'UserController@updateProfile']);

      $router->post('/favorites/', ['uses' => 'UserController@addNoteFavorite']);
      $router->delete('/favorites/{note_id:\d+}', ['uses' => 'UserController@removeNoteFavorite']);
      $router->post('/saved/', ['uses' => 'UserController@addSavedNote']);
      $router->delete('/saved/{note_id:\d+}', ['uses' => 'UserController@removeSavedNote']);
    });
    
    // Free
    $router->group(['prefix' => '{username:[a-zA-Z0-9\-\ñ\Ñ\.\_]+}'], function () use ($router) {
      $router->get('/', [
        'uses' => 'UserController@getOne'
      ]);
      $router->get('/notes/', [
        'uses' => 'UserController@getNotes'
      ]);
      $router->get('/favorite/', [
        'uses' => 'UserController@getNotesFavorite'
      ]);
      $router->get('/saved/', [
        'uses' => 'UserController@getNotesSaved'
      ]);
    });
  });
});

