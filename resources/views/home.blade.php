{{-- 
    Eu, João Victor, estou criando essa atividade de Cooperativa Agropecuária para a aula de PWIII.
    Este arquivo define a Página Inicial (Dashboard Geral) utilizando as diretivas @extends e @section.
    
    COMENTÁRIO TÉCNICO: A view estende o layout 'layouts.app'. Os cards utilizam flexbox e grids 
    do Tailwind CSS para criar uma interface responsiva, simulando painéis de indicadores em tempo real.
--}}

@extends('layouts.app')

@section('title', 'Portal da Cooperativa')

@section('content')
    <!-- SEÇÃO PRINCIPAL: Apresentação Institucional e Alertas Rápidos -->
    <section class="border-b border-farm-200 bg-farm-100">
        <div class="mx-auto grid w-full max-w-6xl gap-8 px-5 py-10 lg:grid-cols-[1fr_1fr] lg:items-stretch lg:px-8 lg:py-14">
            
            <!-- Bloco de Boas-Vindas e Ações Rápidas -->
            <div class="flex flex-col justify-between gap-8 rounded-3xl border border-farm-300 bg-farm-50 p-6 lg:p-8">
                <div class="flex flex-col gap-6">
                    <!-- Badges de Status do Dia -->
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex items-center rounded-xl border border-pasture-500 bg-pasture-100 px-3 py-1.5 text-xs font-semibold text-pasture-800">
                            <span class="mr-1.5 flex h-2 w-2 rounded-full bg-pasture-500 animate-pulse"></span>
                            Silos Operando em Capacidade Ideal
                        </span>
                        <span class="inline-flex items-center rounded-xl border border-barn-300 bg-barn-50 px-3 py-1.5 text-xs font-semibold text-barn-800">
                            Cotações Atualizadas Hoje
                        </span>
                    </div>

                    <!-- Textos Principais -->
                    <div class="flex flex-col gap-5">
                        <h1 class="max-w-3xl text-4xl font-bold leading-tight text-farm-900 sm:text-5xl">
                            AgroCoop Regional
                        </h1>
                        <p class="max-w-2xl text-base leading-7 text-farm-700">
                            Plataforma unificada para o gerenciamento de safras, controle de pesagem e distribuição inteligente de insumos. Conectando o produtor rural às demandas logísticas do mercado interno e de exportação.
                        </p>
                    </div>
                </div>

                <!-- Links de Atalho utilizando as Rotas Nomeadas -->
                <div class="grid gap-3 sm:grid-cols-2">
                    <a href="{{ route('coop.operation') }}" class="rounded-2xl border border-pasture-700 bg-pasture-700 px-5 py-3 text-center text-sm font-semibold text-farm-50 transition-colors duration-200 hover:bg-pasture-800">
                        Painel Operacional
                    </a>
                    <a href="{{ route('coop.report') }}" class="rounded-2xl border border-farm-300 bg-farm-100 px-5 py-3 text-center text-sm font-semibold text-farm-900 transition-colors duration-200 hover:bg-barn-50">
                        Área de Envio Técnico
                    </a>
                </div>
            </div>

            <!-- Monitor de Indicadores Globais da Cooperativa -->
            <div class="flex flex-col gap-4 rounded-3xl border border-farm-300 bg-farm-50 p-6">
                <h3 class="text-lg font-bold text-farm-900 flex items-center gap-2">
                    Resumo Operacional da Safra
                </h3>
                
                <div class="grid gap-3 sm:grid-cols-2 flex-1">
                    <!-- Indicador 1: Armazenamento -->
                    <div class="rounded-2xl border border-farm-200 bg-farm-100 p-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-farm-600">Milho (Armazenado)</span>
                        <p class="mt-2 text-3xl font-extrabold text-farm-900">4,250 <span class="text-sm font-medium">ton</span></p>
                        <div class="mt-3 w-full bg-farm-300 rounded-full h-1.5">
                            <div class="bg-pasture-700 h-1.5 rounded-full" style="width: 70%"></div>
                        </div>
                    </div>

                    <!-- Indicador 2: Pecuária -->
                    <div class="rounded-2xl border border-farm-200 bg-farm-100 p-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-farm-600">Pecuária de Corte</span>
                        <p class="mt-2 text-3xl font-extrabold text-farm-900">1,820 <span class="text-sm font-medium">cab</span></p>
                        <span class="mt-2 inline-flex items-center rounded-md bg-pasture-100 px-2 py-0.5 text-xs font-medium text-pasture-800">Manejo Sanitário OK</span>
                    </div>

                    <!-- Indicador 3: Insumos -->
                    <div class="rounded-2xl border border-farm-200 bg-farm-100 p-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-farm-600">Insumos Disponíveis</span>
                        <p class="mt-2 text-3xl font-extrabold text-farm-900">92 <span class="text-sm font-medium">itens</span></p>
                        <span class="mt-2 inline-flex items-center rounded-md bg-barn-50 px-2 py-0.5 text-xs font-medium text-barn-800">Estoque Regularizado</span>
                    </div>

                    <!-- Indicador 4: Informativo de Próxima Safra -->
                    <div class="rounded-2xl border border-farm-200 bg-farm-100 p-4 flex flex-col justify-center items-center text-center">
                        <span class="text-2xl">🌱</span>
                        <p class="mt-1 text-xs font-semibold text-farm-900">Próxima Safra</p>
                        <p class="text-[11px] text-farm-600">Planejamento e distribuição de sementes liberados.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CARDS DE SERVIÇOS: Apoio e Benefícios ao Cooperado -->
    <section class="mx-auto w-full max-w-6xl px-5 py-12 lg:px-8">
        <h2 class="text-2xl font-bold text-farm-900 mb-8">Serviços e Apoio Logístico</h2>
        
        <div class="grid gap-5 md:grid-cols-3">
            <!-- Card 1: Logística -->
            <article class="rounded-3xl border border-farm-300 bg-farm-100 p-6 flex flex-col justify-between hover:border-pasture-500 transition-all">
                <div>
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-2xl">🚛</span>
                        <span class="bg-pasture-700 text-farm-50 text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-md">Logística Ativa</span>
                    </div>
                    <h3 class="text-lg font-bold text-farm-900">Escoamento de Grãos</h3>
                    <p class="mt-2 text-sm leading-6 text-farm-700">Logística estruturada e frete coordenado para garantir que a colheita saia do campo direto para os silos de armazenamento.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-farm-200 text-xs text-farm-600 font-medium">Monitoramento de frotas ativo</div>
            </article>

            <!-- Card 2: Suporte -->
            <article class="rounded-3xl border border-farm-300 bg-farm-100 p-6 flex flex-col justify-between hover:border-pasture-500 transition-all">
                <div>
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-2xl">🩺</span>
                        <span class="bg-farm-600 text-farm-50 text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-md">Suporte Técnico</span>
                    </div>
                    <h3 class="text-lg font-bold text-farm-900">Assistência Veterinária</h3>
                    <p class="mt-2 text-sm leading-6 text-farm-700">Equipe especializada pronta para aplicar manejos preventivos, controle de pesagem do rebanho e emissão de laudos técnicos.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-farm-200 text-xs text-pasture-700 font-semibold">Suporte de manejo ativado na região</div>
            </article>

            <!-- Card 3: Insumos -->
            <article class="rounded-3xl border border-farm-300 bg-farm-100 p-6 flex flex-col justify-between hover:border-pasture-500 transition-all">
                <div>
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-2xl">💰</span>
                        <span class="bg-barn-700 text-farm-50 text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-md">Incentivo</span>
                    </div>
                    <h3 class="text-lg font-bold text-farm-900">Distribuição de Insumos</h3>
                    <p class="mt-2 text-sm leading-6 text-farm-700">Acesso facilitado a fertilizantes, adubos e defensivos comprados em lotes massivos para garantir o menor preço ao pequeno produtor.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-farm-200 text-xs text-farm-600 font-medium">Pedidos direto no galpão central</div>
            </article>
        </div>
    </section>
@endsection