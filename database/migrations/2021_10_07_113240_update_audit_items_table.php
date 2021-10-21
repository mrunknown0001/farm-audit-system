<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAuditItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audit_items', function ($table) {
            $table->string('location_ids')->nullable()->after('display_time_range');
            $table->boolean('active')->default(1);
            $table->boolean('is_deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_items', function ($table) {
            $table->dropColumn('location_ids');
            $table->dropColumn('active');
            $table->dropColumn('is_deleted');
        });
    }
}
