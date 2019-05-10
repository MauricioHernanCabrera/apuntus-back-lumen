<?php

namespace App;

use App\Helpers\ModelMPK;

class Report extends ModelMPK {
  protected $table = 'reports';
  protected $primaryKey = ['user_id', 'note_id'];
  public $incrementing = false;
  protected $fillable = [
    'user_id',
    'note_id',
    'code_report_id',
  ];
}