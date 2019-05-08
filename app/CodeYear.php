<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodeYear extends Model {
  protected $primaryKey = 'code_year_id';
  public $timestamps = false;
  protected $fillable = ['name'];
}