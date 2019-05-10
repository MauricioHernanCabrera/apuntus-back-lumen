<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodeReport extends Model {
  protected $primaryKey = 'code_report_id';
  public $timestamps = false;
  protected $fillable = ['name'];
}