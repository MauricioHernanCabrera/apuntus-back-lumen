<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNotes extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('notes', function (Blueprint $table) {
      $table->increments('note_id');
      $table->integer('user_id')->unsigned();
      $table->integer('subject_id')->unsigned();
      $table->integer('code_note_id')->unsigned();
      $table->integer('code_year_id')->unsigned();
      $table->string('title', 80);
      $table->string('description', 280)->nullable();

      $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
      $table->foreign('subject_id')->references('subject_id')->on('subjects')->onDelete('cascade');
      $table->foreign('code_note_id')->references('code_note_id')->on('code_notes')->onDelete('cascade');
      $table->foreign('code_year_id')->references('code_year_id')->on('code_years')->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('notes');
  }
}
