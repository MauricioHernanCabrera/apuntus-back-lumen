<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model {
  protected $primaryKey = 'institution_id';
  protected $fillable = ['name'];
}