<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashbondPayrollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('cashbond_payroll');
        Schema::create('cashbond_payroll', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('branch')
                ->onUpdate('cascade')->onDelete('cascade');   
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
        Schema::dropIfExists('cashbond_payroll');
    }
}
