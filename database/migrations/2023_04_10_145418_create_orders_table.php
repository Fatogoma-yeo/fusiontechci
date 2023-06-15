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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string( 'payment_status' ); // paid, unpaid, partially_paid
            $table->string( 'process_status' )->default( 'pending' ); // complete, ongoing, pending
            $table->string( 'delivery_status' )->default( 'pending' ); // pending, shipped, delivered,
            $table->string( 'code' );
            $table->float( 'discount', 18, 5 )->default(0);
            $table->string( 'discount_type' )->nullable();
            $table->boolean( 'support_instalments' )->default(true); // define wether an order should only be paid using instalments feature
            $table->float( 'discount_percentage', 18, 5 )->nullable();
            $table->float( 'subtotal', 18, 5 )->default(0);
            $table->float( 'total', 18, 5 )->default(0);
            $table->float( 'tendered', 18, 5 )->default(0);
            $table->float( 'change', 18, 5 )->default(0);
            $table->datetime( 'final_payment_date' )->nullable();
            $table->integer( 'total_instalments' )->default(0);
            $table->integer( 'customer_id' );
            $table->integer( 'author' );

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
};
