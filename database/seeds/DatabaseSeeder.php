<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class DatabaseSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    $code_reports = [
      'Contenido engañoso o spam',
      'Sexualmente explícito',
      'Violento o peligroso',
      'Acoso, hostigamiento o inicitacion al odio o a la violencia',
      'Información personal y confidencial',
      'Infracción de leyes / derecho de autor'
    ];
    foreach ($code_reports as $item) {
      DB::table('code_reports')->insert([
        'name' => $item
      ]);
    }



    $code_years = [
      '2019/2020',
      '2018/2019',
      '2017/2018',
      '2016/2017',
      '2015/2016',
      '2014/2015',
      '2013/2014',
      '2012/2013',
      '2011/2012',
      '2010/2011',
      '2009/2010',
      '2008/2009',
      '2007/2008',
      '2006/2007',
      '2005/2006',
      '2004/2005',
      '2003/2004',
      '2002/2003',
      '2001/2002',
      '2000/2001',
      'viejisimo',
    ];
    foreach ($code_years as $item) {
      DB::table('code_years')->insert([ 'name' => $item ]);
    }

    

    $code_notes = [
      'Teoria',
      'Resumen',
      'Practico',
      'Ejercicios',
    ];
    foreach ($code_notes as $item) {
      DB::table('code_notes')->insert([ 'name' => $item ]);
    }



    $institutions = [
      'UNNE',
      'UTN'
    ];
    $subjects = [
      'Algoritmos y Estructuras de Datos I',
      'Algebra',
      'Algoritmos y Estructuras de Datos II',
      'Lógica y Matemática Computacional',
      'Sistemas y Organizaciones',
      'Paradigmas y Lenguajes',
      'Arquitectura y Organización de Computadoras',
      'Cálculo Diferencial e Integral',
      'Programación Orientada a Objetos',
      'Sistemas Operativos',
      'Administración y Gestión de Organizaciones',
      'Taller de Programación I',
      'Comunicaciones de Datos',
      'Ingeniería de Software I',
      'Taller de Programación II',
      'Probabilidad y Estadística',
      'Bases de Datos I',
      'Inglés Técnico Informático (extracurricular)',
      'Ingeniería de Software II',
      'Economía Aplicada',
      'Teoría de la Computación',
      'Redes de Datos',
      'Bases de Datos II',
      'Métodos Computacionales',
      'Proyecto Final de Carrera',
      'Auditoria y Seguridad Informática',
      'Optativa I:',
      'Modelos y Simulación',
      'Inteligencia Artificial',
      'Estadística Inferencial',
      'Métodos Computacionales Avanzados',
      'Integración de Redes (Internetworking)',
      'Arquitecturas y Sistemas Operativos Avanzados',
      'Diseño Web Centrado en el Usuario ',
      'Gestión de Recursos Informáticos ',
      'Formulación y Evaluación de Proyectos ',
      'Tópicos Avanzados de Ingeniería de Software'
    ];
    foreach ($institutions as $item) {
      DB::table('institutions')->insert([ 'name' => $item ]);
    }
    foreach ($subjects as $item) {
      DB::table('subjects')->insert([
        'name' => $item,
        'institution_id' => 1
      ]);
      DB::table('subjects')->insert([
        'name' => $item,
        'institution_id' => 2
      ]);
    }



    for ($i = 1; $i <= 10; $i++) {
      $base = Str::random(10);
      DB::table('users')->insert([
        'email' => $base . '@gmail.com',
        'username' => $base,
        'password' => Crypt::encrypt('123456789'),
        'token_user' => Crypt::encrypt('123456789'),
      ]);
    }
    DB::table('users')->insert([
      'email' => 'hola@gmail.com',
      'username' => 'hola',
      'password' => Crypt::encrypt('123456789'),
      'token_user' => Crypt::encrypt('hola@gmail.comhola'),
    ]);


    for ($i = 1; $i <= 10; $i++) {
      
      DB::table('notes')->insert([
        'user_id' => rand(1, 10),
        'subject_id' => rand(1, 70),
        'code_note_id' => rand(1, 4),
        'code_year_id' => rand(1, 21),
        'title' => Str::random(rand(50, 80)),
        'description' => Str::random(rand(120, 280)),
        'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
        'updated_at' => (new \DateTime())->format('Y-m-d H:i:s'),
      ]);
    }


  }
}
