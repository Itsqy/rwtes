<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashbondPayrollDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('cashbond_payroll_detail');
        Schema::create('cashbond_payroll_detail', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('cashbond_payroll_id')->unsigned();
            $table->foreign('cashbond_payroll_id')->references('id')->on('cashbond_payroll')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('employee')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('cashbond', 10, 2);
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
        Schema::dropIfExists('cashbond_payroll_detail');
    }
}
