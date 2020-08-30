<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_returns', function (Blueprint $table) {
            $table->id();
            $table->string("customer_name")->default("");
            $table->string("issue")->default("");
            $table->date("first_contact_date")->nullable()->default(NULL);

            $table->string("order_number")->default("");
            $table->string("tag");
            $table->date("goods_receive_date")->nullable()->default(NULL);
            $table->date("inspected_date")->nullable()->default(NULL);

            $table->string("outcome")->nullable()->default(NULL);
            $table->string("further_action")->nullable()->default(NULL);
            $table->date("closed_date")->nullable()->default(NULL);

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('returns');
    }
}
