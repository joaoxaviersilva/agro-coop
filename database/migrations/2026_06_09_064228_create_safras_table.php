<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('safras', function (Blueprint $table) {
            $table->id();
            $table->string('lote_codigo')->unique(); // Ex: #LT-2026-01
            $table->string('cooperado_nome');
            $table->string('safra_tipo'); // milho, soja, pecuaria, trigo
            $table->double('safra_quantidade', 15, 2); // Peso ou cabeças
            $table->string('classificacao')->default('Em Análise');
            $table->string('status')->default('Pendente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('safras');
    }
};