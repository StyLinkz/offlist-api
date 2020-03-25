<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddsOfferDataToOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->bigInteger('offer_type_id')->after('id');
            $table->bigInteger('offer_category_id')->after('offer_type_id');
            $table->bigInteger('price')->after('offer_category_id');
            $table->bigInteger('price_tax')->after('price')->nullable();
            $table->string('commission')->after('price_tax');
            $table->json('images')->after('commission')->nullable();
            $table->json('location')->after('images')->nullable();
            $table->json('documents')->after('location')->nullable();
            $table->json('seller')->after('documents');
            $table->json('data')->after('seller');
            $table->string('publish_type', 8)->default('public')->after('data');
            $table->enum('status', ['activated', 'deactivated'])->default('activated')->after('publish_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn(['type']);
            $table->dropColumn(['group_type']);
            $table->dropColumn(['price']);
            $table->dropColumn(['commission']);
            $table->dropColumn(['tax']);
            $table->dropColumn(['images']);
            $table->dropColumn(['location']);
            $table->dropColumn(['documents']);
            $table->dropColumn(['seller']);
            $table->dropColumn(['data']);
        });
    }
}
