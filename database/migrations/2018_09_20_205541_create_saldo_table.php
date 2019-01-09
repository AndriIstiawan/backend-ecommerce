<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaldoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('saldo')) {
            Schema::create('saldo', function (Blueprint $table) {
                $table->increments('id');
                $table->string('member_id');
                $table->string('status');
                $table->text('description');
                $table->float('nominal', 13, 2);
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
        Schema::dropIfExists('saldo');
    }
}
