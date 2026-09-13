<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('specialist_profiles', function (Blueprint $table) {
            $table->boolean('show_on_website')
                ->default(true)
                ->after('is_available');
        });
    }

    public function down(): void
    {
        Schema::table('specialist_profiles', function (Blueprint $table) {
            $table->dropColumn('show_on_website');
        });
    }
};