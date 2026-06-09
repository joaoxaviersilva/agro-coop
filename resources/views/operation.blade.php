{{-- 
    Eu, João Victor, estou criando essa atividade de Cooperativa Agropecuária para a aula de PWIII.
    Este arquivo define a tela de Controle Operacional utilizando @extends e @section.
    
    COMENTÁRIO TÉCNICO: Esta view renderiza os dados operacionais através de uma tabela HTML
    estruturada com Tailwind CSS para garantir responsividade no mobile. Os status das unidades
    são controlados visualmente através de badges coloridas (pasture para OK, barn para alertas).
    As duas seções do topo foram alinhadas com lg:items-stretch para garantir simetria visual.
    Os registros da tabela são carregados dinamicamente através do Eloquent ORM utilizando a
    coleção $lotes enviada pelo CooperativaController, seguindo o padrão MVC do Laravel.
--}}

@extends('layouts.app')

@section('title', 'Cooperados & Safras')

@section('content')
    <section class="mx-auto flex w-full max-w-6xl flex-col gap-8 px-5 py-12 lg:px-8 lg:py-16">

        <!-- CABEÇALHO OPERACIONAL: Resumo da movimentação do pátio e status das unidades -->
        <div class="grid gap-5 lg:grid-cols-[0.8fr_1.2fr] lg:items-stretch">

            <!-- Painel de Controle Operacional -->
            <div class="rounded-3xl border border-farm-300 bg-farm-100 p-6 flex flex-col justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase text-barn-700">
                        Controle de Fluxo e Pátio
                    </p>

                    <h1 class="mt-3 text-4xl font-bold leading-tight text-farm-900 sm:text-5xl">
                        Operações Ativas
                    </h1>
                </div>

                <p class="mt-5 text-sm leading-6 text-farm-700">
                    Acompanhe em tempo real a pesagem de lotes agrícolas, a classificação técnica
                    das safras e a triagem de entrada no pátio da cooperativa.
                </p>
            </div>

            <!-- Painel de Status dos Silos e Armazéns -->
            <div class="rounded-3xl border border-pasture-300 bg-pasture-50 p-6 flex flex-col justify-between">
                <h2 class="text-base font-bold text-pasture-900 mb-4">
                    Status dos Silos & Armazéns
                </h2>

                <div class="grid gap-3 sm:grid-cols-2 flex-1 items-center">

                    <div class="rounded-xl border border-pasture-200 bg-farm-50 p-3 flex justify-between items-center shadow-sm">
                        <span class="text-xs font-semibold text-farm-800">Silo Grãos 01</span>
                        <span class="bg-pasture-500 text-farm-50 text-[10px] font-bold px-2 py-0.5 rounded-full">
                            Disponível
                        </span>
                    </div>

                    <div class="rounded-xl border border-pasture-200 bg-farm-50 p-3 flex justify-between items-center shadow-sm">
                        <span class="text-xs font-semibold text-farm-800">Silo Grãos 02</span>
                        <span class="bg-barn-600 text-farm-50 text-[10px] font-bold px-2 py-0.5 rounded-full">
                            Capacidade Limite
                        </span>
                    </div>

                    <div class="rounded-xl border border-pasture-200 bg-farm-50 p-3 flex justify-between items-center shadow-sm">
                        <span class="text-xs font-semibold text-farm-800">Frigorífico Central</span>
                        <span class="bg-pasture-500 text-farm-50 text-[10px] font-bold px-2 py-0.5 rounded-full">
                            Manejo OK
                        </span>
                    </div>

                    <div class="rounded-xl border border-pasture-200 bg-farm-50 p-3 flex justify-between items-center shadow-sm">
                        <span class="text-xs font-semibold text-farm-800">Galpão de Insumos</span>
                        <span class="bg-pasture-500 text-farm-50 text-[10px] font-bold px-2 py-0.5 rounded-full">
                            Triagem Liberada
                        </span>
                    </div>

                </div>
            </div>
        </div>

        <!-- ALERTA DE SUCESSO: Exibido após o cadastro de um novo lote -->
        @if(session('sucesso'))
            <div class="rounded-2xl border border-pasture-300 bg-pasture-100 p-4 text-sm font-semibold text-pasture-800 shadow-sm">
                {{ session('sucesso') }}
            </div>
        @endif

        <!-- TABELA OPERACIONAL: Exibição dinâmica dos lotes registrados no banco -->
        <div class="rounded-3xl border border-farm-300 bg-farm-50 p-6 overflow-hidden">

            <h3 class="text-lg font-bold text-farm-900 mb-4">
                Movimentação Recente de Safras
            </h3>

            <div class="overflow-x-auto">

                <table class="w-full text-left border-collapse text-sm">

                    <thead>
                        <tr class="border-b border-farm-200 text-farm-600">
                            <th class="pb-3 font-semibold">ID Lote</th>
                            <th class="pb-3 font-semibold">Cooperado</th>
                            <th class="pb-3 font-semibold">Cultura</th>
                            <th class="pb-3 font-semibold">Peso Líquido</th>
                            <th class="pb-3 font-semibold">Classificação</th>
                            <th class="pb-3 font-semibold">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-farm-200 text-farm-800">

                        @forelse($lotes as $lote)

                            <tr>

                                <td class="py-4 font-mono font-bold text-pasture-700">
                                    {{ $lote->lote_codigo }}
                                </td>

                                <td class="py-4 font-medium">
                                    {{ $lote->cooperado_nome }}
                                </td>

                                <td class="py-4">
                                    {{ ucfirst($lote->safra_tipo) }}
                                </td>

                                <td class="py-4">
                                    {{ number_format($lote->safra_quantidade, 0, ',', '.') }}
                                </td>

                                <td class="py-4">
                                    {{ $lote->classificacao }}
                                </td>

                                <td class="py-4">

                                    @if($lote->status === 'Descarregado')

                                        <span class="bg-pasture-100 text-pasture-800 text-[11px] font-bold px-2 py-1 rounded-md">
                                            {{ $lote->status }}
                                        </span>

                                    @elseif($lote->status === 'Aguardando GTA')

                                        <span class="bg-barn-50 text-barn-700 text-[11px] font-bold px-2 py-1 rounded-md">
                                            {{ $lote->status }}
                                        </span>

                                    @else

                                        <span class="bg-farm-200 text-farm-800 text-[11px] font-bold px-2 py-1 rounded-md">
                                            {{ $lote->status }}
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="py-10 text-center text-farm-600">
                                    Nenhum lote registrado até o momento.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </section>
@endsection