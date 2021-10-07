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
            # 7 - officers
            # 8 - caretaker/first line employee/user
            $table->bigInteger('farm_id')->nullable();
            $table->string('audit_role')->nullable(); # Specific Role for Farm Audit System
            # 1 - Reviewer
            # 2 - Audit Marshal
            # 3 - Farm/Dept Division Head
            # 4 - Farm/Dept Manager
            # 5 - Farm/Dept Supervisor
            # 6 - Farm Caretaker/Dept Employee
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
