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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->float( 'before_quantity', 18, 5 )->nullable();
            $table->float( 'after_quantity', 18, 5 )->nullable();
            $table->float( 'stock_physic', 18, 5 )->nullable();
            $table->float( 'stock_hs', 18, 5 )->nullable();
            $table->float( 'stock_hs_physic', 18, 5 )->nullable();
            $table->float( 'check_stock_physic_1', 18, 5 )->default(0);
            $table->float( 'check_stock_physic_2', 18, 5 )->default(0);
            $table->float( 'check_stock_hs_1', 18, 5 )->default(0);
            $table->float( 'check_stock_hs_2', 18, 5 )->default(0);
            $table->float( 'unit_price', 18, 5 );
            $table->float( 'purchase_price', 18, 5 );
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
        Schema::dropIfExists('inventories');
    }
};
