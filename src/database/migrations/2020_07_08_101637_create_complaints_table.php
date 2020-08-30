<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();

            $table->date("complaint_date")->nullable()->default(NULL);

            $table->unsignedBigInteger('received_by');
            $table->foreign('received_by')->references('id')->on('users');

            $table->string("receipt_type")->default("");

            $table->string("customer_name")->default("");
            $table->string("description")->default("");
            $table->string("category")->default("");
            $table->string("department")->default("");

            $table->unsignedBigInteger('assigned_to');
            $table->foreign('assigned_to')->references('id')->on('users');

            $table->date("acknowledged_date")->nullable()->default(NULL);

            $table->string("status")->default("Investigating");
            $table->string("root_cause")->default("");

            $table->date("resolved_date")->nullable()->default(NULL);
            $table->unsignedBigInteger('resolved_by')->nullable()->default(NULL);
            $table->foreign('resolved_by')->references('id')->on('users');

            $table->string("corrective_action")->default("");
            $table->string("preventative_action")->default("");

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
        Schema::dropIfExists('complaints');
    }
}
