<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('activity_histories', function (Blueprint $table) {
    $table->id();

    $table->unsignedBigInteger('user_id')->nullable();

    $table->string('action');
    // created, updated, deleted, status_changed

    $table->string('model_type')->nullable();
    $table->unsignedBigInteger('model_id')->nullable();

    $table->text('description')->nullable();

    $table->json('old_values')->nullable();
    $table->json('new_values')->nullable();

    $table->ipAddress('ip_address')->nullable();

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
        Schema::dropIfExists('activity_histories');
    }
}
