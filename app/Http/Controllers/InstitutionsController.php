<?php

namespace App\Http\Controllers;
use App\Institution;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class InstitutionsController extends Controller {
  public function createOne (Request $request) {
    $data = $request->json()->all();
    $institution = Institution::create($data);
    return response()->json($institution, 201);
  }

  public function deleteOne (Request $request, $institution_id) {
    $institution = Institution::findOrFail($institution_id);
    $institution->delete();
    return response()->json($institution, 200);
  }

  public function getAll () {
    $institutions = Institution::all();
    return response()->json($institutions, 200);
  }

  public function getOne (Request $request, $institution_id) {
    $institution = Institution::findOrFail($institution_id);
    return response()->json($institution, 200);
  }

  public function updateOne (Request $request, $institution_id) {
    $data = $request->json()->all();
    $institution = Institution::findOrFail($institution_id);
    $institution->update($data);
    return response()->json($institution, 200);
  }

  public function getSubjects (Request $request, $institution_id) {
    try {
      $subjects = Subject::where('institution_id', $institution_id)->get();
      return response()->json($subjects, 200);
    } catch (ModelNotFoundException $e) {
      return response()->json(['error' => '¡Recurso no encontrado!'], 406);
    }
  }

  // public function createOne (Request $request) {}
  // public function deleteOne (Request $request, $id) {}
  // public function getAll () {}
  // public function getOne (Request $request, $id) {}
  // public function updateOne (Request $request, $id) {}
}
