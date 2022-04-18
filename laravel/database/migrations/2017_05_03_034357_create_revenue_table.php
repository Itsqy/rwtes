<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRevenueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('revenue');
        Schema::create('revenue', function (Blueprint $table) {
            $table->increments('id');            
            $table->date('date')->unique();
            $table->decimal('cash', 15, 2);
            $table->decimal('debit_bca', 15, 2);
            $table->decimal('mastercard', 15, 2);
            $table->decimal('visacard', 15, 2);
            $table->decimal('flazz', 15, 2);
            $table->decimal('other', 15, 2);
            $table->decimal('total', 15, 2);
            $table->decimal('tax_rate', 15, 2);
            $table->decimal('tax', 15, 2);
            $table->decimal('service_charge_rate', 15, 2);
            $table->decimal('service_charge', 15, 2);
            $table->decimal('vat', 15, 2);
            $table->boolean('status')->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('revenue');
    }
}
