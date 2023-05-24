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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string( 'name' );
            $table->integer( 'parent_id' )->default(0)->nullable();
            $table->integer( 'media' )->default(0)->nullable();
            $table->boolean( 'displays_on_pos' )->default(true);
            $table->integer( 'total_items' )->default(0);
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
        Schema::dropIfExists('product_categories');
    }
};
