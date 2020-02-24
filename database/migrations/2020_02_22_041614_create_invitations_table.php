<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('offer_id');
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id')->nullable();
            $table->string('receiver_email');
            $table->string('receiver_prename');
            $table->string('receiver_name');
            $table->string('code', 8);
            $table->timestamp('expired_at');
            $table->enum('status', ['pending', 'accepted', 'expired'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invitations');
    }
}
