<?php

use Modules\QSale\Enum\AddationType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToAddationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addations', function (Blueprint $table) {
            $table->unsignedTinyInteger("type")->index()->default(AddationType::NORMAL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addations', function (Blueprint $table) {
            $table->dropColumn(["type"]);
        });
    }
}
