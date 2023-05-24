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
        Schema::create('cash_flows', function (Blueprint $table) {
            $table->id();
            $table->integer( 'expense_id' )->nullable();
            $table->string( 'operation' ); // credit or debit
            $table->integer( 'expense_category_id' )->nullable();
            $table->integer( 'procurement_id' )->nullable();  // to link an expense to an order refund.
            $table->integer( 'order_id' )->nullable(); // to link an expense to an order refund.
            $table->integer( 'customer_account_id' )->nullable(); // if a customer credit is generated
            $table->string( 'name' );
            $table->string( 'status' )->default('active');
            $table->float( 'value', 18, 5 )->default(0);
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
        Schema::dropIfExists('cash_flows');
    }
};
