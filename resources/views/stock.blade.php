{{-- 
    Eu, João Victor, estou criando essa atividade de Cooperativa Agropecuária para a aula de PWIII.
    Este arquivo define a nova tela de Mercado & Estoque de Silos utilizando @extends e @section.
    
    COMENTÁRIO TÉCNICO: Esta view inovadora centraliza as informações financeiras de commodities 
    e o volume de inventário agrícola. As barras de progresso dos silos são construídas utilizando 
    divs aninhadas com larguras percentuais do Tailwind (w-9/10 e w-1/3), dispensando scripts externos.
--}}

@extends('layouts.app')

@section('title', 'Mercado & Estoque')

@section('content')
    <section class="mx-auto flex w-full max-w-6xl flex-col gap-8 px-5 py-12 lg:px-8 lg:py-16">
        
        <!-- Cabeçalho da Página -->
        <div>
            <span class="bg-pasture-100 text-pasture-800 text-xs font-bold uppercase tracking-wider px-2.5 py-1 rounded-md">Indicadores de Mercado</span>
            <h1 class="mt-2 text-4xl font-bold text-farm-900">Cotações do Dia & Monitoramento de Silos</h1>
            <p class="mt-2 text-sm text-farm-700">Painel integrado com as variações da bolsa de commodities e controle de volumetria física dos armazéns centrais.</p>
        </div>

        <!-- PAINEL DE COTAÇÕES: Cards com as variações de preços do agronegócio -->
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Card Soja -->
            <div class="rounded-2xl border border-farm-300 bg-farm-50 p-5 shadow-sm">
                <span class="text-xs font-bold text-farm-600 uppercase">Saca de Soja (60kg)</span>
                <div class="mt-2 flex items-baseline justify-between">
                    <p class="text-2xl font-black text-farm-900">R$ 138,40</p>
                    <span class="text-xs font-bold text-pasture-700 bg-pasture-100 px-2 py-0.5 rounded">+2.41%</span>
                </div>
            </div>
            
            <!-- Card Milho -->
            <div class="rounded-2xl border border-farm-300 bg-farm-50 p-5 shadow-sm">
                <span class="text-xs font-bold text-farm-600 uppercase">Saca de Milho (60kg)</span>
                <div class="mt-2 flex items-baseline justify-between">
                    <p class="text-2xl font-black text-farm-900">R$ 62,15</p>
                    <span class="text-xs font-bold text-barn-700 bg-barn-50 px-2 py-0.5 rounded">-0.85%</span>
                </div>
            </div>
            
            <!-- Card Boi Gordo -->
            <div class="rounded-2xl border border-farm-300 bg-farm-50 p-5 shadow-sm">
                <span class="text-xs font-bold text-farm-600 uppercase">Arroba do Boi Gordo</span>
                <div class="mt-2 flex items-baseline justify-between">
                    <p class="text-2xl font-black text-farm-900">R$ 242,00</p>
                    <span class="text-xs font-bold text-pasture-700 bg-pasture-100 px-2 py-0.5 rounded">+1.12%</span>
                </div>
            </div>
            
            <!-- Card Trigo -->
            <div class="rounded-2xl border border-farm-300 bg-farm-50 p-5 shadow-sm">
                <span class="text-xs font-bold text-farm-600 uppercase">Trigo Nacional (ton)</span>
                <div class="mt-2 flex items-baseline justify-between">
                    <p class="text-2xl font-black text-farm-900">R$ 1.280,00</p>
                    <span class="text-xs font-bold text-farm-700 bg-farm-200 px-2 py-0.5 rounded">0.00%</span>
                </div>
            </div>
        </div>

        <!-- CAPACIDADE DOS SILOS: Gráficos visuais baseados em CSS estruturado -->
        <div class="grid gap-6 md:grid-cols-2">
            <!-- Silo Norte -->
            <div class="rounded-3xl border border-farm-300 bg-farm-50 p-6 shadow-sm">
                <h3 class="font-bold text-farm-900 mb-4">Ocupação Física: Silo Horizontal Norte</h3>
                <div class="flex justify-between text-xs text-farm-700 mb-1">
                    <span>Capacidade Máxima: 5.000t</span>
                    <span class="font-bold text-barn-700">90% Ocupado</span>
                </div>
                <!-- Barra de Progresso Crítica (Usa w-9/10 para simular os 90% na div do Tailwind) -->
                <div class="w-full bg-farm-200 rounded-full h-4 overflow-hidden border border-farm-300">
                    <div class="bg-barn-600 h-4 rounded-full w-9/10"></div>
                </div>
                <p class="mt-3 text-xs text-barn-700 font-semibold flex items-center gap-1">
                    <span>⚠️</span> Alerta técnico: Agendar transbordo de grãos com urgência.
                </p>
            </div>

            <!-- Silo Sul -->
            <div class="rounded-3xl border border-farm-300 bg-farm-50 p-6 shadow-sm">
                <h3 class="font-bold text-farm-900 mb-4">Ocupação Física: Silo Vertical Sul</h3>
                <div class="flex justify-between text-xs text-farm-700 mb-1">
                    <span>Capacidade Máxima: 8.000t</span>
                    <span class="font-bold text-pasture-800">35% Ocupado</span>
                </div>
                <!-- Barra de Progresso Estável (Usa w-1/3 para simular aproximadamente 35% na div do Tailwind) -->
                <div class="w-full bg-farm-200 rounded-full h-4 overflow-hidden border border-farm-300">
                    <div class="bg-pasture-700 h-4 rounded-full w-1/3"></div>
                </div>
                <p class="mt-3 text-xs text-pasture-700 font-semibold flex items-center gap-1">
                    <span>✓</span> Unidade operacional: Liberado para recepção de novos lotes de milho.
                </p>
            </div>
        </div>
        
    </section>
@endsection