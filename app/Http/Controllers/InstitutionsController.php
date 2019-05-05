<?php

namespace App\Http\Controllers;
use App\Institution;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class InstitutionsController extends Controller {
  public function createOne (Request $request) {
    $this->validate($request, [
      'name' => 'required|string|unique:institutions,name|max:100'
    ]);
    $data = $request->json()->all();
    $allowed_fields = ['name'];
    $institution = Institution::create(array_only($data, $allowed_fields));
    return response()->json($institution, 201);
  }

  public function getAll () {
    $institutions = Institution::all();
    return response()->json($institutions, 200);
  }

  public function getSubjects (Request $request, $institution_id) {
    $subjects = Subject::where('institution_id', $institution_id)->get();
    return response()->json($subjects, 200);
  }
}
