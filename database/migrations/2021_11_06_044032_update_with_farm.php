<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWithFarm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->bigInteger('farm_id');
        });
        Schema::table('sub_locations', function (Blueprint $table) {
            $table->bigInteger('farm_id');
        });
        Schema::table('audit_items', function (Blueprint $table) {
            $table->bigInteger('farm_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('farm_id');
        });
        Schema::table('sub_locations', function (Blueprint $table) {
            $table->dropColumn('farm_id');
        });
        Schema::table('audit_items', function (Blueprint $table) {
            $table->dropColumn('farm_id');
        });
    }
}
