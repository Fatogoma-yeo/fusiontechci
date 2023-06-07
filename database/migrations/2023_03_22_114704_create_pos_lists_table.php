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
        Schema::create('pos_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('product_name');
            $table->float('net_purchase_price');
            $table->float('gross_purchase_price');
            $table->float( 'discount', 18, 5 )->default(0);
            $table->float( 'pos_discount', 18, 5 )->nullable();
            $table->integer('quantity');
            $table->integer('is_gross')->default(0);
            $table->integer('author_id');

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
        Schema::dropIfExists('pos_lists');
    }
};
