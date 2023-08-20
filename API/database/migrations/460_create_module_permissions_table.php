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
        Schema::create('module_permissions', function (Blueprint $table) {
            $table->comment('Available Permissions for each modules');
            $table->foreignId('module')->constrained('modules');
            $table->foreignId('permission')->constrained('permissions');
            $table->boolean('checked')->nullable()->comment('default checked or not');
            $table->boolean('read_only')->nullable()->comment('ui read only');
            $table->string('comment')->nullable();
            $table->unique(array('module', 'permission'));
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
        Schema::dropIfExists('module_permissions');
    }
};
