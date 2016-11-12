<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroceryListItemPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grocery_list_item', function (Blueprint $table) {
            $table->integer('grocery_list_id')->unsigned()->index();
            $table->foreign('grocery_list_id')->references('id')->on('grocery_list')->onDelete('cascade');
            $table->integer('item_id')->unsigned()->index();
            $table->foreign('item_id')->references('id')->on('item')->onDelete('cascade');
            $table->primary(['grocery_list_id', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('grocery_list_item');
    }
}
