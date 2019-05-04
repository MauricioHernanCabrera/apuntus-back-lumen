<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model {
  protected $primaryKey = 'subject_id';
  // public $timestamps = false;

  protected $guarded = [];
  
  // protected $fillable = [];

  // protected $hidden = [''];

  public function institution () {
    return $this->belongsTo('App\Institution', 'institution_id');
  }
}