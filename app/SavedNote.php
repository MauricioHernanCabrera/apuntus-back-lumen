<?php

namespace App;

use App\Helpers\ModelMPK;

class SavedNote extends ModelMPK {
  protected $table = 'saved_notes';
  public $incrementing = false;
  protected $primaryKey = ['user_id', 'note_id'];
  protected $fillable = ['user_id', 'note_id'];
}