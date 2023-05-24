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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string( 'name' );
            $table->string( 'first_name' )->nullable();
            $table->integer( 'author_id' );
            $table->string( 'gender' )->nullable();
            $table->string( 'phone' )->nullable();
            $table->string( 'email' )->nullable();
            $table->datetime( 'birth_date' )->nullable();
            $table->float( 'purchases_amount', 18, 5 )->default(0);
            $table->float( 'owed_amount', 18, 5 )->default(0);
            $table->float( 'credit_limit_amount', 18, 5 )->default(0)->nullable();
            $table->float( 'account_amount', 18, 5 )->default(0);
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
        Schema::dropIfExists('clients');
    }
};
