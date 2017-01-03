<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameItemCategoryTableToDepartments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('item_categories', 'departments');

        Schema::table('items', function ($table) {
            $table->dropForeign(['item_category_id']);
            $table->renameColumn('item_category_id', 'department_id');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('departments', 'item_categories');

        Schema::table('items', function ($table) {
            $table->dropForeign(['department_id']);
            $table->renameColumn('department_id', 'item_category_id');
            $table->foreign('item_category_id')->references('id')->on('item_categories')->onDelete('cascade');
        });
    }
}
