<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('course_sections', function (Blueprint $table) {
            $table->integer('sort_order')->default(0)->after('section_title');
        });

        Schema::table('course_lectures', function (Blueprint $table) {
            $table->integer('sort_order')->default(0)->after('video_duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_sections', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });

        Schema::table('course_lectures', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
};
