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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->string( 'product_name' );
            $table->integer( 'product_id' );
            $table->integer( 'order_id' );
            $table->integer( 'product_category_id' );
            $table->integer( 'procurement_product_id' )->nullable();
            $table->string( 'status' )->default( 'sold' ); // sold, refunded
            $table->float( 'discount', 18, 5 )->default(0);
            $table->float( 'quantity', 18, 5 ); // could be the base unit
            $table->float( 'discount_percentage', 18, 5 )->default(0);
            $table->float( 'unit_price', 18, 5 )->default(0);
            $table->string( 'pos_subtotal', 18, 5 )->default(0);
            $table->string( 'purchase_price', 18, 5 )->default(0);
            $table->float( 'total_price', 18, 5 )->default(0);
            $table->integer( 'author_id' );

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
        Schema::dropIfExists('order_products');
    }
};
