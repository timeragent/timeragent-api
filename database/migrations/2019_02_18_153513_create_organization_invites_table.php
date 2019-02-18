<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_invites', function (Blueprint $table) {
            $table->uuid('uuid')->index()->unique();
            $table->uuid('organization_uuid');
            $table->foreign('organization_uuid')
                  ->references('uuid')
                  ->on('organizations')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->string('email');
            $table->string('token')->index();
            $table->string('status');
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
        Schema::dropIfExists('organization_invites');
    }
}
