<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyColumnsToUnsigned extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crusts', function (Blueprint $table) {
            $table->integer('price')->unsigned()->change();
        });

        Schema::table('serving_sizes', function (Blueprint $table) {
            $table->integer('price')->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crusts', function (Blueprint $table) {
            $table->integer('price')->default(0)->change();
        });

        Schema::table('serving_sizes', function (Blueprint $table) {
            $table->integer('price')->change();
        });
    }
}
