<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name', 100); // Employee's name (max 100 characters)
            $table->integer('age'); // Employee's age
            $table->string('email', 100)->unique(); // Employee's email (unique, max 100 characters)
            $table->date('date_of_birth'); // Employee's date of birth
            $table->string('address', 255)->nullable(); // Employee's address (max 255 characters, optional)
            $table->binary('photo')->nullable(); // Employee's photo (optional)
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
