<?php

use App\Enums\BuildingType;
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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nickname', 50)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('governate', 50);
            $table->string('type')->default(BuildingType::Home->value);
            $table->string('building', 20)->nullable();
            $table->tinyInteger('floor')->nullable();
            $table->string('apartment', 10)->nullable();
            $table->text('details')->nullable();
            $table->string('neighborhood', 100)->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_main')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
