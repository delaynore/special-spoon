<?php

use App\Models\RelationType;
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
        Schema::table('relation_types', function (Blueprint $table) {
            $table->string('name_plural', 255)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('relation_types', function (Blueprint $table) {
            $table->dropColumn(['name_plural']);
        });
    }
};
