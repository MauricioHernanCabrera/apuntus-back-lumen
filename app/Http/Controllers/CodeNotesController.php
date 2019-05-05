<?php

namespace App\Http\Controllers;
use App\CodeNote;
use Illuminate\Http\Request;

class CodeNotesController extends Controller {
  public function getAll () {
    $code_notes = CodeNote::all();
    return response()->json($code_notes, 200);
  }
}
