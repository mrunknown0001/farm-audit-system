<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_reviews', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('audit_id')->unsigned();
            $table->bigInteger('user_id')->unsigned(); // Reviewer ID
            $table->boolean('verified')->default(0); // Reviewed and Validated Non-Compliance 
            $table->text('review')->nullable(); // Review or Remarks
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
        Schema::dropIfExists('audit_reviews');
    }
}
