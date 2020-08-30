<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyOutcomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_returns', function (Blueprint $table) {
            $table->dropColumn('outcome');
        });

        Schema::table('product_returns', function (Blueprint $table) {
            $table->integer("outcome")->default(0);
        });
    }

}
