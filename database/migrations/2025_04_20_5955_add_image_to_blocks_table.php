<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToBlocksTable extends Migration
{
    public function up()
    {
        Schema::table('post_blocks', function (Blueprint $table) {
            $table->string('image')->nullable()->after('content');
        });
    }

    public function down()
    {
        Schema::table('blocks', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}
