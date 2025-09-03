<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécuter les migrations.
     */
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            
            // Informations du membre
            $table->string('member_name')->nullable();
            $table->string('member_number')->nullable();
            $table->string('member_phone')->nullable();
            $table->string('member_email')->nullable();
            
            // Détails de la plainte
            $table->string('subject');
            $table->enum('category', ['service', 'credit', 'epargne', 'technique', 'autre']);
            $table->text('description');
            
            // Statut et suivi
            $table->enum('status', ['pending', 'processing', 'resolved', 'closed'])->default('pending');
            $table->string('reference')->unique();
            $table->text('admin_notes')->nullable();
            $table->timestamp('resolved_at')->nullable();
            
            // Pièces jointes (stockées en JSON)
            $table->json('attachments')->nullable();
            
            // Informations de sécurité
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Index pour améliorer les performances
            $table->index(['status', 'created_at']);
            $table->index(['category', 'created_at']);
            $table->index('reference');
            $table->index('member_number');
        });
    }

    /**
     * Annuler les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
