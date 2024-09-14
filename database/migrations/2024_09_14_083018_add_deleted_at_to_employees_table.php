<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToEmployeesTable extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->softDeletes(); // Adds a nullable deleted_at TIMESTAMP column
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropSoftDeletes(); // Drops the deleted_at column
        });
    }
}
