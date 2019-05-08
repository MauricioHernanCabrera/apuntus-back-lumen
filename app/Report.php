<?php

namespace App;

use App\Helpers\ModelMPK;

class NoteFavorite extends ModelMPK {
  protected $primaryKey = ['user_id', 'note_id'];
  protected $fillable = [
    'user_id',
    'note_id',
    'code_report_id',
  ];
}