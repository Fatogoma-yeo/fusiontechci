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
        Schema::create('procurements', function (Blueprint $table) {
            $table->id();
            $table->string( 'name' );
            $table->float( 'value', 18, 5 )->default(0);
            $table->float( 'cost', 18, 5 )->default(0);
            $table->datetime( 'invoice_date' )->nullable();
            $table->string( 'payment_status' )->default( 'unpaid' );
            $table->integer( 'author_id' );
            $table->integer('provider_id');
            
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
        Schema::dropIfExists('procurements');
    }
};
