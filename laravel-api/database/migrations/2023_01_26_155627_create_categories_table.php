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
        Schema::create('1_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent')->nullable()->constrained('1_categories');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->string('image')->nullable()->unique();
            $table->boolean('allow_sub')->nullable();
            $table->boolean('editable')->nullable();
            $table->boolean('deletable')->nullable();
            $table->unique(array('parent','name'),'slug');
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
        Schema::dropIfExists('1_categories');
    }
};
