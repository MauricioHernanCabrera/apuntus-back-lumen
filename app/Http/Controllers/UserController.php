<?php

namespace App\Http\Controllers;

use App\User;
use App\Note;
use App\NoteFavorite;
use App\SavedNote;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;


class UserController extends Controller {
  public function updateProfile (Request $request) {
    $this->validate($request, [
      'username' => 'regex:/^[a-zA-Z0-9\-\ñ\Ñ\.\_]+$/|unique:users,username|max:60',
      'email' => 'email|unique:users,email|max:100',
      'password' => 'max:200',
    ]);

    $data = $request->json()->all();
    $user = $request->user();
    $user->update($data);
    return response()->json($user, 200);
  }

  public function addNoteFavorite (Request $request) {
    $data = $request->json()->all();
    $user = $request->user();

    $this->validate($request, [
      'note_id' => [
        'required',
        /*
          Validar que la note_id no exista en el usuario pasado por parametro
        */
        Rule::unique('notes_favorite', 'note_id')->where(function ($query) use ($user) {
          return $query->where('user_id', $user->user_id);
        }),
      ],
    ]);


    $note = NoteFavorite::create([
      'user_id' => $user->user_id,
      'note_id' => $data['note_id']
    ]);

    return response()->json($note, 201);
  }

  public function removeNoteFavorite (Request $request, $note_id) {
    $user = $request->user();
    
    $note = NoteFavorite::where([
      'user_id' => $user->user_id,
      'note_id' => $note_id
    ])->firstOrFail();

    $note->delete();
    return response()->json($note, 200);
  }

  public function addSavedNote (Request $request) {
    $data = $request->json()->all();
    $user = $request->user();

    $this->validate($request, [
      'note_id' => [
        'required',
        /*
          Validar que la note_id no exista en el usuario pasado por parametro
        */
        Rule::unique('saved_notes', 'note_id')->where(function ($query) use ($user) {
          return $query->where('user_id', $user->user_id);
        }),
      ],
    ]);

    $note = SavedNote::create([
      'user_id' => $user->user_id,
      'note_id' => $data['note_id']
    ]);

    return response()->json($note, 201);
  }

  public function removeSavedNote (Request $request, $note_id) {
    $user = $request->user();
    
    $note = SavedNote::where([
      'user_id' => $user->user_id,
      'note_id' => $note_id
    ])->firstOrFail();

    $note->delete();
    return response()->json($note, 200);
  }

  public function getOne (Request $request, $username) {
    $user = User::where('username', $username)->firstOrFail();
    return response()->json($user, 200);
  }

  public function getNotes (Request $request, $username) {
    $user = User::where('username', $username)->firstOrFail();
    $notes = Note::with('user', 'subject.institution', 'code_note', 'code_year', 'notes_favorite', 'saved_notes')
      ->where(['user_id' => $user->user_id])
      ->get();
    return response()->json($notes, 200);
  }
  
  public function getNotesFavorite (Request $request, $username) {
    $user = User::where('username', $username)->firstOrFail();
    $notes_favorite = NoteFavorite::where(['user_id' => $user->user_id])->get();

    $ids_notes_favorite = $notes_favorite->map(function ($item, $key) {
      return $item->note_id;
    });

    if (sizeof($ids_notes_favorite) > 0) {
      $notes = Note::with('user', 'subject.institution', 'code_note', 'code_year', 'notes_favorite', 'saved_notes')
        ->whereIn('note_id', $ids_notes_favorite)
        ->get();
      return response()->json($notes, 200);
    }

    return response()->json([], 200);
  }

  public function getNotesSaved (Request $request, $username) {
    $user = User::where('username', $username)->firstOrFail();
    
    $saved_notes = SavedNote::where(['user_id' => $user->user_id])->get();

    $ids_saved_notes = $saved_notes->map(function ($item, $key) {
      return $item->note_id;
    });

    if (sizeof($ids_saved_notes) > 0) {
      $notes = Note::with('user', 'subject.institution', 'code_note', 'code_year', 'notes_favorite', 'saved_notes')
        ->whereIn('note_id', $ids_saved_notes)
        ->get();
      return response()->json($notes, 200);
    }

    return response()->json([], 200);
  }
}
