<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Subject;

class SubjectsController extends Controller {
  public function createOne (Request $request) {
    $data = $request->json()->all();
    $subject = Subject::create($data);
    return response()->json($subject, 201);
  }

  public function deleteOne (Request $request, $subject_id) {
    $subject = Subject::findOrFail($subject_id);
    $subject->delete();
    return response()->json($subject, 200);
  }

  public function getOne (Request $request, $subject_id) {
    $subject = Subject::findOrFail($subject_id);
    return response()->json($subject, 200);
  }

  public function updateOne (Request $request, $subject_id) {
    $data = $request->json()->all();
    $subject = Subject::findOrFail($subject_id);
    $subject->update($data);
    return response()->json($subject, 200);
  }
}
