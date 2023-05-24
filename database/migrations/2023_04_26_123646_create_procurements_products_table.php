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
        Schema::create('procurements_products', function (Blueprint $table) {
            $table->id();
            $table->string( 'product_name' );
            $table->float( 'gross_purchase_price', 18, 5 )->default(0);
            $table->float( 'net_purchase_price', 18, 5 )->default(0);
            $table->float( 'purchase_price', 18, 5 )->default(0);
            $table->float( 'quantity', 18, 5 );
            $table->float( 'total_purchase_price', 18, 5 )->default(0);
            $table->integer( 'author_id' );
            $table->integer('procurement_id')->nullable();
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
        Schema::dropIfExists('procurements_products');
    }
};
