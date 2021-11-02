<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('audit_item_category_id')->unsigned()->nullable(); // Audit Name ID
            $table->text('item_name')->nullable();
            $table->text('description')->nullable();
            $table->string('time_range')->nullable(); // To be Display
            $table->string('display_time_range')->nullable(); // Array of Time Range When to display
            $table->string('location_ids')->nullable(); // Moved with separate model
            $table->boolean('active')->default(1);
            $table->boolean('is_deleted')->default(0);
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
        Schema::dropIfExists('audit_items');
    }
}
