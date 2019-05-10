<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
  use Authenticatable, Authorizable;

  protected $primaryKey = 'user_id';

  protected $fillable = [
    'password',
    'token_user',
    'email',
    'username',
  ];

  protected $hidden = [
    'password',
    'token_user'
  ];

  public function notes_favorite () {
    return $this->belongsToMany('App\Note', 'notes_favorite', 'user_id', 'note_id');
  }

  public function saved_notes () {
    return $this->belongsToMany('App\Note', 'saved_notes', 'user_id', 'note_id');
  }
}
