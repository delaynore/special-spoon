<?php

use App\Enums\AttachmentType;
use App\Enums\DataType;
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
        Schema::create('concepts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('fk_dictionary_id')->references('id')->on('dictionaries')->cascadeOnDelete();
            $table->string('name', 255);
            $table->string('definition', 1000);
            $table->timestampsTz();

            $table->unique(['fk_dictionary_id','name']);
            $table->unique('id');
            $table->foreignUuid('fk_parent_concept_id')->nullable()->references('id')->on('concepts')->cascadeOnDelete();
        });

        Schema::create('relation_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 255);
            $table->string('description', 1000);
            $table->timestampsTz();

            $table->unique('name');
        });

        Schema::create('concept_relations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('fk_concept_1_id')->references('id')->on('concepts')->cascadeOnDelete();
            $table->foreignUuid('fk_concept_2_id')->references('id')->on('concepts')->cascadeOnDelete();
            $table->foreignUuid('fk_relation_type_id')->references('id')->on('relation_types')->cascadeOnDelete();
            $table->timestampsTz();

            $table->unique(['fk_concept_1_id', 'fk_concept_2_id', 'fk_relation_type_id']);
        });

        Schema::create('attachments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name',255);
            $table->enum('type', array_column(AttachmentType::cases(), 'value'));
            $table->string('path', 255);
            $table->foreignUuid('fk_user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreignUuid('fk_concept_id')->references('id')->on('concepts')->cascadeOnDelete();
            $table->timestampsTz();

            $table->unique(['name', 'path']);
        });

        Schema::create('attributes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // Заготовка - привязка на понятие.
            $table->uuid('fk_concept_id')->nullable();
            $table->string('name',255);
            $table->enum('type', array_column(DataType::cases(), 'value'));
            $table->timestampsTz();

            $table->unique(['name']);
        });

        Schema::create('concept_attributes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('fk_concept_id')->references('id')->on('concepts')->cascadeOnDelete();
            $table->foreignUuid('fk_attribute_id')->references('id')->on('attributes')->cascadeOnDelete();
            $table->timestampsTz();
            $table->integer('group')->nullable();

            $table->unique(['fk_concept_id', 'fk_attribute_id']);
        });

        Schema::create('concept_attribute_values', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('fk_attribute_id')->nullable()->references('id')->on('attributes')->cascadeOnDelete();
            $table->foreignUuid('fk_concept_attribute_id')->references('id')->on('concept_attributes')->cascadeOnDelete();
            $table->timestampsTz();
            $table->integer('example_number');
            $table->string('value');

            $table->unique(['fk_attribute_id', 'fk_concept_attribute_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concepts');
        Schema::dropIfExists('relation_types');
        Schema::dropIfExists('concept_relations');
        Schema::dropIfExists('attacments');
        Schema::dropIfExists('attributes');
        Schema::dropIfExists('concept_attributes');
        Schema::dropIfExists('concept_attributes_values');

    }
};
