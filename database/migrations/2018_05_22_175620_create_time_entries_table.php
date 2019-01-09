<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_entries', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->index();

            $table->uuid('task_uuid');
            $table->foreign('task_uuid')
                ->references('uuid')
                ->on('tasks')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->boolean('active')->nullable();
            $table->dateTime('start_time')->index();
            $table->dateTime('end_time')->nullable();

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
        Schema::dropIfExists('time_entries');
    }
}
