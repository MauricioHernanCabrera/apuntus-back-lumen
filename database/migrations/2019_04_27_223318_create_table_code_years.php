<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCodeYears extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('code_years', function (Blueprint $table) {
      $table->increments('code_year_id');
      $table->string('name', 10)->unique();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('code_years');
  }
}
