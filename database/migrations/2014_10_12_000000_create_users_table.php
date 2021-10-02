<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100)->nullable();
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('suffix_name', 100)->nullable();
            $table->string('company_id', 100)->nullable();
            $table->string('username', 50)->nullable();
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->bigInteger('role_id')->nullable();
            # 1 - super admin
            # 2 - admin
            # 3 - vp
            # 4 - divhead
            # 5 - manager
            # 6 - supervisor
            # 7 - caretaker/first line employee
            $table->bigInteger('farm_id')->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('is_deleted')->default(0);
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
