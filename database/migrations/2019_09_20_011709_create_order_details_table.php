<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('shoulder_width');
            $table->double('chest_circumference');
            $table->double('middle_body');
            $table->double('buttocks');
            $table->double('arm_length');
            $table->double('arm_circumference');
            $table->double('wristband');
            $table->double('overall_height');
            $table->double('one_shoulder');
            $table->double('back_length');
            $table->double('from_shoulder_to_chest');
            $table->double('from_shoulder_middle');
            $table->double('pocket_length');

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
