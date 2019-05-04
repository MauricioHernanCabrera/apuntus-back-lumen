<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Note extends Model {
  protected $primaryKey = 'note_id';
  // public $timestamps = false;

  protected $guarded = [];
  
  // protected $fillable = [];

  // protected $hidden = [''];

  public function user () {
    return $this->belongsTo('App\User', 'user_id');
  }
  
  public function subject () {
    return $this->belongsTo('App\Subject', 'subject_id');
  }

  public function code_note () {
    return $this->belongsTo('App\CodeNote', 'code_note_id');
  }

  public function code_year () {
    return $this->belongsTo('App\CodeYear', 'code_year_id');
  }

  public function notes_favorite () {
    return $this->belongsToMany('App\User', 'notes_favorite', 'note_id', 'user_id');
  }

  public function notes_saved () {
    return $this->belongsToMany('App\User', 'notes_saved', 'note_id', 'user_id');
  }
}