<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSenderPhoneAndSenderMessageToApplicationTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('applications', function (Blueprint $table) {
      $table->string('sender_phone');
      $table->string('sender_message');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('applications', function (Blueprint $table) {
      Schema::dropIfExists('applications');
    });
  }
}
