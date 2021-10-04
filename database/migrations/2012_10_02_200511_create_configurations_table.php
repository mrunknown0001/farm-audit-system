<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string('system_name', 100)->nullable();
            $table->string('system_short_name', 50)->nullable();
            $table->string('system_description', 200)->nullable();
            $table->string('system_title_suffix', 50)->nullable();
            $table->string('admin_skin', '20')->nullable()->default('skin-red');
            $table->string('user_skin', '20')->nullable()->default('skin-blue');
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
        Schema::dropIfExists('configurations');
    }
}
