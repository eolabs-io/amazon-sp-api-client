<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use EolabsIo\AmazonSpApiClient\Shared\Migrations\AmazonSpApiClientMigration;

class CreateParticipationsTable extends AmazonSpApiClientMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('marketplace_id');
            $table->string('seller_id');
            $table->string('has_seller_suspended_listings');
            $table->timestamps();

            $table->unique(['marketplace_id', 'seller_id']);
            $table->foreign('marketplace_id')->references('marketplace_id')->on('marketplaces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participations');
    }
}
