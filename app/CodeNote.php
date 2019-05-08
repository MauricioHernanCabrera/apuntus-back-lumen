<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodeNote extends Model {
  protected $primaryKey = 'code_note_id';
  public $timestamps = false;
  protected $fillable = ['name'];
}