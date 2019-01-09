<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_user', function (Blueprint $table) {
            $table->uuid('project_uuid');
            $table->foreign('project_uuid')
                ->references('uuid')
                ->on('projects')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->uuid('user_uuid');
            $table->foreign('user_uuid')
                ->references('uuid')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unique(['project_uuid', 'user_uuid']);

            $table->uuid('team_uuid')->nullable();
            $table->foreign('team_uuid')
                ->references('uuid')
                ->on('teams')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->float('cost_rate')->unsigned()->nullable();
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
        Schema::dropIfExists('project_user');
    }
}
