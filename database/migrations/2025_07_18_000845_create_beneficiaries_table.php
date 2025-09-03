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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('physical_person_submission_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('moral_person_submission_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('nom');
            $table->string('contact');
            $table->string('lien');
            $table->date('birth_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
