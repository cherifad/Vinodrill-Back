<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // rename column
            $table->renameColumn('firstname', 'prenomclient');
            $table->renameColumn('lastname', 'nomclient');
            $table->renameColumn('birthdate', 'datenaissance');
            $table->renameColumn('phone', 'telephone');
            $table->renameColumn('password', 'motdepasse');
            $table->renameColumn('email', 'emailclient');
            $table->renameColumn('id', 'idclient');

            // add new integer column
            $table->integer('idcb')->nullable();
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
            //
        });
    }
};
