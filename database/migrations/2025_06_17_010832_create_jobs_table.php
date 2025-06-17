<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('location')->nullable();
            $table->string('type');
            $table->string('salary_range')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('department')->nullable();
            $table->integer('required_experience')->nullable(); // In years
            $table->string('required_education')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
