<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('uuid')->index()->unique();
            $table->string('name');

            $table->uuid('client_uuid')->nullable();
            $table->foreign('client_uuid')
                ->references('uuid')
                ->on('clients')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->string('owner_type');

            $table->uuid("owner_uuid");

            $table->index(["owner_type", "owner_uuid"]);
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
        Schema::dropIfExists('projects');
    }
}
