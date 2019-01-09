<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'organization_user', function (Blueprint $table) {
            $table->uuid('user_uuid')->index();
            $table->uuid('organization_uuid')->index();
            $table->tinyInteger('status')->default(2);

            $table->foreign('user_uuid')->references('uuid')->on('users')->onDelete('cascade');

            $table->timestamps();
        }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_user');
    }
}
