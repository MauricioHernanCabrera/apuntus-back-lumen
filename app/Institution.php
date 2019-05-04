<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model {
  protected $primaryKey = 'institution_id';
  // public $timestamps = false;

  protected $guarded = [];
  
  // protected $fillable = ['name'];

  // protected $hidden = [''];
}