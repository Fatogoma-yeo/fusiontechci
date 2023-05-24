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
        Schema::create('product_histories', function (Blueprint $table) {
            $table->id();
            $table->string( 'product_name' );
            $table->integer( 'procurement_id' )->nullable();
            $table->string( 'procurement_name' );
            $table->integer( 'order_id' )->nullable();
            $table->string( 'operation' );
            $table->float( 'before_quantity', 18, 5 )->nullable();
            $table->float( 'quantity', 18, 5 );
            $table->float( 'after_quantity', 18, 5 )->nullable();
            $table->float( 'unit_price', 18, 5 );
            $table->float( 'purchase_price', 18, 5 );
            $table->float( 'total_price', 18, 5 );
            $table->integer( 'author_id' );
            $table->integer('product_id')->nullable();

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
        Schema::dropIfExists('product_histories');
    }
};
