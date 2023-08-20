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
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->comment('Module based role permissions');
            $table->foreignId('role_id')->constrained('roles');
            $table->foreignId('module_id')->constrained('modules');
            $table->foreignId('permission_id')->constrained('permissions');
            $table->boolean('readonly')->nullable()->comment('read only or manually added rows, no changes can be made from ui');
            $table->boolean('allow')->default(0)->comment('1 - Allow, 0 - Deny');
            $table->boolean('disabled')->nullable();
            $table->string('comment')->nullable();
            $table->unique(array('role_id', 'module_id', 'permission_id'), 'slug');
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
        Schema::dropIfExists('role_permissions');
    }
};
