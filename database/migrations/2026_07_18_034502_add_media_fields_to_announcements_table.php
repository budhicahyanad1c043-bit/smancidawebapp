<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->string('flyer')->nullable()->after('content');
            $table->string('link_url')->nullable()->after('flyer');
            $table->string('related_topics')->nullable()->after('link_url');
        });
    }

    public function down()
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn(['flyer', 'link_url', 'related_topics']);
        });
    }
};
