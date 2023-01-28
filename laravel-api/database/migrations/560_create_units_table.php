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
        Schema::create('units', function (Blueprint $table) {
            $table->comment('Measurement units');
            $table->id();
            $table->foreignId('base')->nullable()->constrained('units');
            $table->string('code')->unique();
            $table->string('name')->unique();
            $table->decimal('step', $precision = 8, $scale = 2)->nullable()->comment('for sub units only');
            $table->boolean('allow_decimal')->nullable();
            $table->string('description')->nullable();
            $table->boolean('locked')->nullable();
            $table->unique(array('base', 'step'));
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
        Schema::dropIfExists('units');
    }
};
