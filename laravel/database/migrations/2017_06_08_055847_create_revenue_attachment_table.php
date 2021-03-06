<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRevenueAttachmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('revenue_attachment');
        Schema::create('revenue_attachment', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('revenue_id')->unsigned();
            $table->foreign('revenue_id')->references('id')->on('revenue')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('filename');
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
        Schema::dropIfExists('revenue_attachment');
    }
}
