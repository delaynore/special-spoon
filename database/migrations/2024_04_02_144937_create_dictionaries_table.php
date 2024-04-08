<?php

use App\Enums\Visibility;
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
        Schema::create('dictionaries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('fk_user_id')->references('id')->on('users')->restrictOnDelete();
            $table->string('name', 50);
            $table->string('description', 500)->nullable();
            $table->enum('visibility', array_column(Visibility::cases(), 'value'))->default(Visibility::PRIVATE->value);
            $table->timestampsTz();

            $table->unique(['name', 'fk_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dictionaries');
    }
};
