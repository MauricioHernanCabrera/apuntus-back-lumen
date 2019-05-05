<?php

namespace App\Http\Controllers;

use App\Note;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NotesController extends Controller {
  public function createOne (Request $request) {
    try {
      $data = $request->json()->all();
      $token_user = $request->header('token_user');
      $user = User::where('token_user', '=', $token_user)->first();

      $data['user_id'] = $user->user_id;
      $note = Note::create($data);
      return response()->json($note, 201);
    } catch (ModelNotFoundException $e) {
      return response()->json(['error' => '¡Usuario o contraseña invalido!'], 404);
    }
  }

  public function deleteOne (Request $request, $note_id) {
    $note = Note::findOrFail($note_id);
    $note->delete();
    return response()->json($note, 200);
  }

  public function getAll (Request $request) {
    $query = $request->query();

    $fields = ['subject_id', 'code_year_id', 'code_note_id'];
    $relations = ['user', 'subject.institution', 'code_note', 'code_year', 'notes_favorite', 'notes_saved'];
    
    
    
    $consulta = Note::with($relations)
      ->where(array_only($query, $fields));
    
    if (isset($query['institution_id'])) {
      $institution_id = $query['institution_id'];
      
      $consulta = $consulta
        ->whereHas('subject', function ($query) use ($institution_id) {
          $query->where('institution_id', '=', $institution_id);
        });
    }

    if (isset($query['title'])) {
      $title = $query['title'];

      $consulta = $consulta
        ->where(function ($query) use ($title) {
          $query
            ->where('title', 'like', '%' . $title . '%')
            ->orWhere('description', 'like', '%' . $title . '%');
        });
    }

    $notes = $consulta->get();
    
    return response()->json($notes, 200);
  }
  
  public function getOne (Request $request, $note_id) {
    $note = Note::findOrFail($note_id)->load('user', 'subject.institution', 'code_note', 'code_year', 'notes_favorite', 'notes_saved');
    return response()->json($note, 200);
  }
}
