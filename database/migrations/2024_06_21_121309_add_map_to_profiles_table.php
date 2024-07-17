<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMapToProfilesTable extends Migration
{
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->text('map')->nullable()->after('instagram');
        });
    }

    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('map');
        });
    }
}
