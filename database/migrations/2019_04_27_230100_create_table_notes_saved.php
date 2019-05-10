<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNotesSaved extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('saved_notes', function (Blueprint $table) {
      $table->integer('user_id')->unsigned();
      $table->integer('note_id')->unsigned();
      
      $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
      $table->foreign('note_id')->references('note_id')->on('notes')->onDelete('cascade');

      $table->primary(['user_id', 'note_id']);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('saved_notes');
  }
}
