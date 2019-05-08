<?php

namespace App\Http\Controllers;
use App\CodeYear;
use Illuminate\Http\Request;

class CodeYearsController extends Controller {
  public function createOne (Request $request) {
    $data = $request->json()->all();
    $code_year = CodeYear::create($data);
    return response()->json($code_year, 201);
  }

  public function getAll () {
    $code_years = CodeYear::all();
    return response()->json($code_years, 200);
  }

  public function getOne (Request $request, $code_year_id) {
    $code_year = CodeYear::firstOrFail($code_year_id);
    return response()->json($code_year, 200);
  }
}
