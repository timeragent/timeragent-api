<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'users', function (Blueprint $table) {
            $table->uuid('uuid')->index()->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('verification_token', 100);
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('admin')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
