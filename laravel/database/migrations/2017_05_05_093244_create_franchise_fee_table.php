<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFranchiseFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('franchise_fee');
        Schema::create('franchise_fee', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('branch')
                ->onUpdate('cascade')->onDelete('cascade');   
            $table->integer('month');
            $table->integer('year');
            $table->boolean('status');
            $table->decimal('royalty_percentage', 10, 2);
            $table->decimal('royalty_value', 10, 2);
            $table->date('invoice_date');
            $table->string('invoice_file');
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
        Schema::dropIfExists('franchise_fee');
    }
}
