<?php

namespace App;

use App\Helpers\ModelMPK;

class NoteSaved extends ModelMPK {
  public $table = 'notes_saved';
  public $incrementing = false;
  protected $primaryKey = ['user_id', 'note_id'];
  protected $fillable = ['user_id', 'note_id'];
}