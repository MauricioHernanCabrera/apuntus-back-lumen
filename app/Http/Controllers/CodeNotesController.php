<?php

namespace App\Http\Controllers;
use App\CodeNote;
use Illuminate\Http\Request;

class CodeNotesController extends Controller {
  public function createOne (Request $request) {
    $data = $request->json()->all();
    $code_note = CodeNote::create($data);
    return response()->json($code_note, 201);
  }

  public function getAll () {
    $code_notes = CodeNote::all();
    return response()->json($code_notes, 200);
  }

  public function getOne (Request $request, $code_note_id) {
    $code_note = CodeNote::findOrFail($code_note_id);
    return response()->json($code_note, 200);
  }
}
