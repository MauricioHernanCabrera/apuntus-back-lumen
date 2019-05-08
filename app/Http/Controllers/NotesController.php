<?php

namespace App\Http\Controllers;

use App\Note;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NotesController extends Controller {
  public function createOne (Request $request) {
    $this->validate($request, [
      'title' => 'required|max:80',
      'description' => 'max:280',
      'subject_id' => 'required|numeric|exists:subjects,subject_id',
      'code_note_id' => 'required|numeric|exists:code_notes,code_note_id',
      'code_year_id' => 'required|numeric|exists:code_years,code_year_id',
    ]);
    
    $data = $request->json()->all();
    $data['user_id'] = $request->user()->user_id;

    $note = Note::create($data);
    return response()->json($note, 201);
  }

  public function deleteOne (Request $request, $note_id) {
    $note = Note::firstOrFail($note_id);

    if ($note->user->user_id == $request->user()->user_id) {
      $note->delete();
      return response()->json($note, 200);
    } else {
      return response(['error' => '¡Usuario no autorizado!'], 401);
    }
  }

  public function getAll (Request $request) {
    $query = $request->query();

    $allowed_fields = ['subject_id', 'code_year_id', 'code_note_id'];
    $relations = ['user', 'subject.institution', 'code_note', 'code_year', 'notes_favorite', 'notes_saved'];
    
    /* 
      Agregar filtro por subject_id, code_year_id, code_note_id y cargar
      relaciones user, subject.institution, code_note, code_year, 
      notes_favorite, notes_saved
    */
    $consulta = Note::with($relations)->where(array_only($query, $allowed_fields));
    
    if (isset($query['institution_id'])) {
      // Agregar filtro por institution id
      $institution_id = $query['institution_id'];
      
      $consulta = $consulta
        ->whereHas('subject', function ($query) use ($institution_id) {
          $query->where('institution_id', '=', $institution_id);
        });
    }

    if (isset($query['title'])) {
      // Agregar filtro por texto en la busqueda al titulo y descripcion
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
    $note = Note::firstOrFail($note_id)
      ->load('user', 'subject.institution', 'code_note', 'code_year', 'notes_favorite', 'notes_saved');
    return response()->json($note, 200);
  }
}
