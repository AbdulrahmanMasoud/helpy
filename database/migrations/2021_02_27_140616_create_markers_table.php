<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('markers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('title');
            $table->enum('gender',['ذكر','انثى']);
            $table->enum('mental_state',['سوي عقليا','غير سوي عقليا']);
            $table->enum('adult',['طفل','بالغ','مُسن']);
            $table->text('description')->nullable();
            $table->unsignedDecimal('latitude', 10, 8);
            $table->unsignedDecimal('longitude', 11, 8);
            $table->string('proof')->nullable();
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('markers');
    }
}
