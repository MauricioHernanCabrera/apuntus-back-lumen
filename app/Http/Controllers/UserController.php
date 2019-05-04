<?php

namespace App\Http\Controllers;

use App\User;
use App\Note;
use App\NoteFavorite;
use App\NoteSaved;
use Illuminate\Http\Request;


class UserController extends Controller {
  public function addNoteFavorite (Request $request) {
    $data = $request->json()->all();

    $token_user = $request->header('token_user');
    $user = User::where(['token_user' => $token_user])->first();

    $note = NoteFavorite::create([
      'user_id' => $user->user_id,
      'note_id' => $data['note_id']
    ]);

    return response()->json($note, 200);
  }

  public function removeNoteFavorite (Request $request, $note_id) {
    $token_user = $request->header('token_user');
    $user = User::where('token_user', '=', $token_user)->first();
    
    $note = NoteFavorite::where([
      'user_id' => $user->user_id,
      'note_id' => $note_id
    ])->first();

    $note->delete();
    return response()->json($note, 200);
  }

  public function addNoteSaved (Request $request) {
    $data = $request->json()->all();

    $token_user = $request->header('token_user');
    $user = User::where(['token_user' => $token_user])->first();

    $note = NoteSaved::create([
      'user_id' => $user->user_id,
      'note_id' => $data['note_id']
    ]);

    return response()->json($note, 200);
  }

  public function removeNoteSaved (Request $request, $note_id) {
    $token_user = $request->header('token_user');
    $user = User::where('token_user', '=', $token_user)->first();
    
    $note = NoteSaved::where([
      'user_id' => $user->user_id,
      'note_id' => $note_id
    ])->first();

    $note->delete();
    return response()->json($note, 200);
  }

  public function getOne (Request $request, $username) {
    $user = User::where('username', '=', $username)->first();
    return response()->json($user, 200);
  }

  public function getNotes (Request $request, $username) {
    $user = User::where('username', '=', $username)->first();
    $notes = Note::with('user', 'subject.institution', 'code_note', 'code_year', 'notes_favorite', 'notes_saved')
      ->where(['user_id' => $user->user_id])
      ->get();
    return response()->json($notes, 200);
  }
  
  public function getNotesFavorite (Request $request, $username) {
    $user = User::where('username', '=', $username)->first();
    $notes_favorite = NoteFavorite::where(['user_id' => $user->user_id])->get();
    $ids_notes_favorite = $notes_favorite->map(function ($item, $key) {
      return $item->note_id;
    });

    if (sizeof($ids_notes_favorite) > 0) {
      $notes = Note::with('user', 'subject.institution', 'code_note', 'code_year', 'notes_favorite', 'notes_saved')
        ->whereIn('note_id', $ids_notes_favorite)
        ->get();
      return response()->json($notes, 200);
    }

    return response()->json([], 200);
  }

  public function getNotesSaved (Request $request, $username) {
    $user = User::where('username', '=', $username)->first();
    $notes_saved = NoteSaved::where(['user_id' => $user->user_id])->get();
    $ids_notes_saved = $notes_saved->map(function ($item, $key) {
      return $item->note_id;
    });

    if (sizeof($ids_notes_saved) > 0) {
      $notes = Note::with('user', 'subject.institution', 'code_note', 'code_year', 'notes_favorite', 'notes_saved')
        ->whereIn('note_id', $ids_notes_saved)
        ->get();
      return response()->json($notes, 200);
    }

    return response()->json([], 200);
  }
}
