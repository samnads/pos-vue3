<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('code');
            $table->foreignId('role_id')->constrained('roles');
            $table->string('username');
            $table->string('password');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('company_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone');
            $table->string('avatar')->nullable();
            $table->foreignId('gender_id')->constrained('genders');
            $table->foreignId('country_id')->constrained('countries');
            $table->string('city');
            $table->string('place');
            $table->string('pin_code');
            $table->string('address');
            $table->string('description');
            $table->foreignId('status_id')->constrained('statuses');
            $table->boolean('locked')->nullable();
            $table->string('login_ip');
            $table->dateTime('login_at')->nullable();
            $table->dateTime('logout_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
};
