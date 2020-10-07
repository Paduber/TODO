<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');

        });

        Schema::create('priorities', function (Blueprint $table) {
            $table->id();
            $table->string('name');

        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->date('end_date');
            $table->unsignedBigInteger('priority');
            $table->unsignedBigInteger('status');
            $table->unsignedBigInteger('assigned_user_id');
            $table->unsignedBigInteger('created_user_id');
            $table->timestamps();


            $table->foreign('assigned_user_id')->references('id')->on('users');
            $table->foreign('created_user_id')->references('id')->on('users');
            $table->foreign('priority')->references('id')->on('priorities');
            $table->foreign('status')->references('id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
