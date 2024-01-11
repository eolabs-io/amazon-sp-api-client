<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use EolabsIo\AmazonSpApiClient\Shared\Migrations\AmazonSpApiClientMigration;

class CreateEndpointsTable extends AmazonSpApiClientMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('endpoints', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('country_code', 2)->unique();
            $table->string('endpoint');
            $table->string('marketplace_id')->unique();
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
        Schema::dropIfExists('endpoints');
    }
}
