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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->comment('Supplier contact details');
            $table->id();
            $table->string('code')->unique();
            $table->string('name')->index();
            $table->string('place')->index();
            $table->string('address')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('gst_no')->nullable();
            $table->string('tax_no')->nullable();
            $table->string('description')->nullable();
            $table->boolean('locked')->nullable();
            $table->foreignId('status')->constrained('statuses');
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
        Schema::dropIfExists('suppliers');
    }
};
