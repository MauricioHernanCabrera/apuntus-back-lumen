<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Subject;
use App\Institution;

class SubjectsController extends Controller {
  public function createOne (Request $request) {
    $data = $request->json()->all();

    $this->validate($request, [
      'institution_id' => [
        'required',
        'numeric',
        'exists:institutions,institution_id',
      ],
      'name' => [
        'required',
        'string',
        'max:100',
        /*
          El nombre de la materia puede ser igual siempre 
          y cuando pertenezca a otra institution
        */
        Rule::unique('subjects', 'name')->where(function ($query) use ($data) {
          $institution_id = isset($data['institution_id'])? $data['institution_id'] : 0;
          return $query->where('institution_id', '=', $institution_id);
        }),
      ],
    ]);
    
    $subject = Subject::create($data);
    return response()->json($subject, 201);
  }
}
