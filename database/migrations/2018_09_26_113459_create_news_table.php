<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('news')) {
            Schema::create('news', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->longText('description');
                $table->string('image');
                $table->jsonb('keywords');
                $table->boolean('is_publish')->default(false);
                $table->string('created_by');
                $table->string('updated_by');
                $table->string('deleted_by');
                $table->timestamps();
                $table->softDeletes();
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
        Schema::dropIfExists('news');
    }
}
