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
        Schema::create('1_label_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name')->unique();
            $table->decimal('p_width', $precision = 6, $scale = 2);
            $table->decimal('p_height', $precision = 6, $scale = 2);
            $table->integer('labels');
            $table->decimal('l_width', $precision = 6, $scale = 2);
            $table->decimal('l_height', $precision = 6, $scale = 2);
            $table->decimal('rows', $precision = 6, $scale = 2);
            $table->decimal('columns', $precision = 6, $scale = 2);
            $table->decimal('row_gutter', $precision = 6, $scale = 2);
            $table->decimal('column_gutter', $precision = 6, $scale = 2);
            $table->decimal('margin_t', $precision = 6, $scale = 2);
            $table->decimal('margin_r', $precision = 6, $scale = 2);
            $table->decimal('margin_b', $precision = 6, $scale = 2);
            $table->decimal('margin_l', $precision = 6, $scale = 2);
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
        Schema::dropIfExists('1_label_sizes');
    }
};
