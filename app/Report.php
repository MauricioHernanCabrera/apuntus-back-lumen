<?php

namespace App;

use App\Helpers\ModelMPK;

class NoteFavorite extends ModelMPK {
  protected $primaryKey = ['user_id', 'note_id'];
  protected $guarded = [];
}