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
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('css_class')->nullable();
            $table->string('css_color')->nullable();
            $table->boolean('online_status')->nullable()->index();
            $table->boolean('payment_status')->nullable()->index();
            $table->boolean('order_status')->nullable()->index();
            $table->boolean('role_status')->nullable()->index();
            $table->boolean('user_status')->nullable()->index();
            $table->boolean('warehouse_status')->nullable()->index();
            $table->boolean('pos_sale_status')->nullable()->index();
            $table->boolean('purchase_status')->nullable()->index();
            $table->boolean('purchase_return_status')->nullable()->index();
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
        Schema::dropIfExists('statuses');
    }
};
