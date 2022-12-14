<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddsUserInfoToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('prename')->after('id');
            $table->string('phone')->after('email')->nullable();
            $table->string('company')->after('phone')->nullable();
            $table->string('offer_types')->after('company')->nullable();
            $table->string('role', 8)->after('offer_types')->default('user');
            $table->string('reset_password_token', 8)->after('api_token')->nullable();
            $table->timestamp('reset_password_token_expired_at')
                  ->after('reset_password_token')
                  ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['prename']);
            $table->dropColumn(['phone']);
            $table->dropColumn(['company']);
            $table->dropColumn(['offer_types']);
        });
    }
}
