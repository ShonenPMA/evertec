<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name', 80);
            $table->string('customer_email', 120);
            $table->string('customer_mobile', 40);

            $table->string('status', 40)->default('CREATED');
            $table->string('code')->unique();
            $table->integer('request_id')->nullable();
            $table->string('product_name');
            $table->float('total')->nullable();

            $table->index(['code']);
            $table->index(['customer_mobile']);
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
        Schema::dropIfExists('orders');
    }
}
