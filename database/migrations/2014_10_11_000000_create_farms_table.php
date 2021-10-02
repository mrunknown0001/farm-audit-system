<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farms', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->string('code', 20)->nullable()->unique();
            $table->text('description')->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('is_deleted')->default(0);
            $table->string('f1', 199)->nullable();
            $table->string('f2', 199)->nullable();
            $table->string('f3', 199)->nullable();
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
        Schema::dropIfExists('farms');
    }
}
