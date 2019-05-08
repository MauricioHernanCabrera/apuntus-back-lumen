<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model {
  protected $primaryKey = 'subject_id';
  protected $fillable = [
    'institution_id',
    'name'
  ];
  public function institution () {
    return $this->belongsTo('App\Institution', 'institution_id');
  }
}