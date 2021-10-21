<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned(); // Auditor/Marshal ID
            $table->bigInteger('audit_item_id')->unsigned();
            $table->bigInteger('location_id')->nullable();
            $table->bigInteger('sub_location_id')->nullable();
            $table->string('compliance')->nullable(); // Compliant or Non-Compliant
            $table->text('non_compliance_remarks')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->boolean('reviewed')->default(0);
            $table->timestamp('date_reviewed')->nullable();
            $table->boolean('verified')->default(0); // Reviewed and Validated Non-Compliance
            $table->text('field1')->nullable(); // Category for loc/sub
            $table->text('field2')->nullable();
            $table->text('field3')->nullable();
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
        Schema::dropIfExists('audits');
    }
}
