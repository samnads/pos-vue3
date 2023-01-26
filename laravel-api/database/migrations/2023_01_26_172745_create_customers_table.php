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
        Schema::create('1_customers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('parent')->nullable()->constrained('1_customers');
            $table->foreignId('customer_group')->constrained('1_customer_groups');
            $table->string('name');
            $table->string('place');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('address')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('city')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('status')->constrained('1_statuses');
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
        Schema::dropIfExists('1_customers');
    }
};
