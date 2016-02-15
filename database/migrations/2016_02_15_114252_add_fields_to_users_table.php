<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->unique('name');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('staff_nos')->nullable();

            $table->unique('staff_nos');
            $table->integer('department_id')->unsigned()->nullable();

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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_department_id_foreign');
            $table->dropUnique('users_staff_nos_unique');
            $table->dropColumn('staff_nos');
            $table->dropColumn('department_id');
        });
        Schema::dropIfExists('departments');
    }
}
