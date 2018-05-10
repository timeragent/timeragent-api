<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('uuid')->index()->unique();

            $table->uuid('organization_uuid');
            $table->foreign('organization_uuid')
                ->references('uuid')
                ->on('organizations')
                ->onDelete('cascade')
                ->onUodate('cascade');

            $table->uuid('contact_uuid')->nullable();
            $table->foreign('contact_uuid')
                ->references('uuid')
                ->on('contacts')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->string('name');
            $table->text('address')->nullable();
            $table->string('invoice_prefix', 2)->nullable();
            $table->float('rate')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
