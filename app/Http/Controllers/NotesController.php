<?php

namespace App\Http\Controllers;

use App\Note;
use App\User;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
  
  public function reportOne (Request $request, $note_id) {
    $data = $request->json()->all();
    $user = $request->user();
    $request['note_id'] = $note_id;

    $this->validate($request, [
      'note_id' => [
        'required',
        /*
          Validar que la note_id no exista en el usuario pasado por parametro
        */
        Rule::unique('reports', 'note_id')->where(function ($query) use ($user) {
          return $query->where('user_id', $user->user_id);
        }),
      ],
      'code_report_id' => [
        'required',
        'exists:code_reports,code_report_id'
      ]
    ]);

    $report = Report::create([
      'user_id' => $user->user_id,
      'note_id' => $note_id,
      'code_report_id' => $data['code_report_id'],
    ]);

    return response()->json($report, 201);
  }

  public function getAll (Request $request) {
    $query = $request->query();

    $allowed_fields = ['subject_id', 'code_year_id', 'code_note_id'];
    $relations = ['user', 'subject.institution', 'code_note', 'code_year', 'notes_favorite', 'saved_notes'];
    
    /* 
      Agregar filtro por subject_id, code_year_id, code_note_id y cargar
      relaciones user, subject.institution, code_note, code_year, 
      notes_favorite, saved_notes
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
      ->load('user', 'subject.institution', 'code_note', 'code_year', 'notes_favorite', 'saved_notes');
    return response()->json($note, 200);
  }
}
