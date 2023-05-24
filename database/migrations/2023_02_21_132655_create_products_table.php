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
        Schema::create('products', function (Blueprint $table) {
            $table->id('id');
            $table->string( 'name' );
            $table->string( 'status' )->default( 'available' ); // available, unavailable
            $table->string( 'stock_management' )->default( 'enabled' ); // enabled, disabled
            $table->integer( 'parent_id' )->default(0); // to refer to a parent variable product
            $table->string( 'media' );
            $table->integer( 'author_id' );
            $table->integer('category_id');
            
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
        Schema::dropIfExists('products');
    }
};
