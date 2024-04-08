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
        Schema::create('tags', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->timestampsTz();

            $table->unique('name');
        });

        Schema::create('dictionary_tags', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('fk_dictionary_id')->references('id')->on('dictionaries')->cascadeOnDelete();
            $table->foreignUuid('fk_tag_id')->references('id')->on('tags')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dictionary_tags');
        Schema::dropIfExists('tags');
    }
};
