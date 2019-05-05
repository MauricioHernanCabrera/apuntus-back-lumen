<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReports extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('reports', function (Blueprint $table) {
      $table->integer('user_id')->unsigned();
      $table->integer('note_id')->unsigned();
      $table->integer('code_report_id')->unsigned();
      
      $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
      $table->foreign('note_id')->references('note_id')->on('notes')->onDelete('cascade');
      $table->foreign('code_report_id')->references('code_report_id')->on('code_reports')->onDelete('cascade');

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
    Schema::dropIfExists('reports');
  }
}
