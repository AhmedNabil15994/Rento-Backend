<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficeCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_categories', function (Blueprint $table) {
            $table->unsignedBigInteger("office_id");
            $table->foreign('office_id')
                                ->references('id')->on('offices')
                                ->onUpdated("cascade")
                                ->onDelete('cascade');   
            $table->unsignedBigInteger("category_id");
            $table->foreign('category_id')
                                ->references('id')->on('categories')
                                ->onUpdated("cascade")
                                ->onDelete('cascade');                       
            $table->primary(["category_id", "office_id"]);
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
        Schema::dropIfExists('office_categories');
    }
}
