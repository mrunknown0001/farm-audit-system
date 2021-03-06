<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditItemChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_item_checklists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('audit_item_id')->unsigned();
            $table->foreign('audit_item_id')->references('id')->on('audit_items');
            $table->text('checklist')->nullable();
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
        Schema::dropIfExists('audit_item_checklists');
    }
}
