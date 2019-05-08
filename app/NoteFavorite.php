<?php

namespace App;

use App\Helpers\ModelMPK;

class NoteFavorite extends ModelMPK {
  public $table = 'notes_favorite';
  public $incrementing = false;
  protected $primaryKey = ['user_id', 'note_id'];
  protected $fillable = ['user_id', 'note_id'];
}