<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductsTableAddMoreColumns extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('slno')->nullable();
            $table->string('chapterID')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('moq')->nullable();
            $table->string('standardISO')->nullable();
            $table->string('grade')->nullable();
            $table->string('threadType')->nullable();
            $table->string('metric')->nullable();
            $table->string('standardType')->nullable();
            $table->string('point')->nullable();
            $table->float('pitch')->nullable();
            $table->string('pitchType')->nullable();
            $table->float('weight')->nullable();


            // Already existing:
            // $table->primary('ProductID');
            // $table->foreignId('SubCategoryID')->constrained('sub_categories');
            // $table->foreignId('ManufacturerID')->constrained('manufacturers');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'slno', 'grade', 'threadType', 'metric', 
                'standardType', 'point', 'pitch', 'pitchType', 'weight', 'discount','moq',
                'chapterID','standardISO',
            ]);
        });
    }
}
