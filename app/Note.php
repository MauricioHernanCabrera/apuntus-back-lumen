<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Note extends Model {
  protected $primaryKey = 'note_id';
  protected $fillable = [
    'user_id',
    'subject_id',
    'code_note_id',
    'code_year_id',
    'title',
    'description',
    'google_folder_id'
  ];

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

  public function saved_notes () {
    return $this->belongsToMany('App\User', 'saved_notes', 'note_id', 'user_id');
  }

  public function is_favorite ($user) {
    $is_favorite = $this->notes_favorite->contains($user);
    $this->makeHidden(['notes_favorite']);
    return $user !== null && $is_favorite;
  }

  public function is_saved ($user) {
    $is_saved = $this->saved_notes->contains($user);
    $this->makeHidden(['saved_notes']);
    return $user !== null && $is_saved;
  }
}