<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSegmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('segment_products')) {
            Schema::create('segment_products', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->integer('order');
                $table->string('images');
                $table->char('type');
                $table->jsonb('products');
                $table->string('created_by');
                $table->string('updated_by');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('segments');
    }
}
