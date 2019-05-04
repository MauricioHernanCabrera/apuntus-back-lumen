<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSubjects extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('subjects', function (Blueprint $table) {
      $table->increments('subject_id');
      $table->string('name', 100);
      $table->integer('institution_id')->unsigned();
      $table->foreign('institution_id')->references('institution_id')->on('institutions')->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('subjects');
  }
}
