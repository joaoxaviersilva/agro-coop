{{-- 
    Eu, João Victor, estou criando essa atividade de Cooperativa Agropecuária para a aula de PWIII.
    Este arquivo define a tela de Lançamento Técnico de Safras utilizando @extends e @section.
    
    COMENTÁRIO TÉCNICO: O formulário implementa a diretiva obrigatória @csrf do Laravel para
    proteção contra ataques de falsificação de solicitação cruzada. A interface utiliza um grid
    assimétrico (lg:grid-cols-[1.3fr_0.7fr]) para acomodar as validações de negócio ao lado dos inputs.
    Os dados submetidos são processados pelo CooperativaController e persistidos no banco através
    do Model Safra. O histórico lateral é carregado dinamicamente utilizando registros recentes
    recuperados pelo Eloquent ORM.
--}}

@extends('layouts.app')

@section('title', 'Enviar Relatório')

@section('content')
    <section class="mx-auto flex w-full max-w-6xl flex-col gap-8 px-5 py-12 lg:px-8 lg:py-16">

        <!-- CABEÇALHO PRINCIPAL: Área de lançamento de novos lotes -->
        <div>
            <h1 class="text-4xl font-bold text-farm-900">
                Lançamento Técnico de Safras
            </h1>

            <p class="mt-2 text-sm text-farm-700">
                Módulo operacional voltado ao registro, pesagem e triagem de mercadorias
                recebidas dos cooperados.
            </p>
        </div>

        <!-- EXIBIÇÃO DE ERROS DE VALIDAÇÃO RETORNADOS PELO LARAVEL -->
        @if ($errors->any())
            <div class="rounded-2xl border border-barn-300 bg-barn-50 p-4">
                <h3 class="mb-2 text-sm font-bold text-barn-700">
                    Foram encontrados problemas no envio:
                </h3>

                <ul class="list-disc pl-5 text-sm text-barn-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- ESTRUTURA PRINCIPAL: Formulário e painel lateral -->
        <div class="grid gap-8 lg:grid-cols-[1.3fr_0.7fr]">

            <!-- COLUNA ESQUERDA: Cadastro de novos lotes -->
            <div class="rounded-3xl border border-farm-300 bg-farm-50 p-6 shadow-sm">

                <h2 class="text-lg font-bold text-farm-900 mb-6">
                    Formulário de Entrada de Lotes
                </h2>

                <form
                    action="{{ route('coop.storeReport') }}"
                    method="POST"
                    class="flex flex-col gap-5"
                >
                    @csrf

                    <!-- Campo Nome do Cooperado -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-farm-700 mb-2">
                            Produtor Cooperado
                        </label>

                        <input
                            type="text"
                            name="cooperado_nome"
                            value="{{ old('cooperado_nome') }}"
                            placeholder="Ex: Nome do Produtor"
                            class="w-full rounded-xl border border-farm-300 bg-farm-100 p-3 text-sm text-farm-900 focus:border-pasture-700 focus:ring-0"
                        >
                    </div>

                    <!-- Linha Cultura e Quantidade -->
                    <div class="grid gap-4 sm:grid-cols-2">

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-farm-700 mb-2">
                                Cultura / Produto
                            </label>

                            <select
                                name="safra_tipo"
                                class="w-full rounded-xl border border-farm-300 bg-farm-100 p-3 text-sm text-farm-900 focus:border-pasture-700 focus:ring-0"
                            >
                                <option value="milho" {{ old('safra_tipo') == 'milho' ? 'selected' : '' }}>
                                    Milho em Grão
                                </option>

                                <option value="soja" {{ old('safra_tipo') == 'soja' ? 'selected' : '' }}>
                                    Soja Comercial
                                </option>

                                <option value="pecuaria" {{ old('safra_tipo') == 'pecuaria' ? 'selected' : '' }}>
                                    Pecuária de Corte
                                </option>

                                <option value="trigo" {{ old('safra_tipo') == 'trigo' ? 'selected' : '' }}>
                                    Trigo Especial
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-farm-700 mb-2">
                                Volume / Peso (KG ou Cab.)
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="safra_quantidade"
                                value="{{ old('safra_quantidade') }}"
                                placeholder="Ex: 15000"
                                class="w-full rounded-xl border border-farm-300 bg-farm-100 p-3 text-sm text-farm-900 focus:border-pasture-700 focus:ring-0"
                            >
                        </div>

                    </div>

                    <!-- Botão de envio -->
                    <button
                        type="submit"
                        class="mt-2 rounded-2xl bg-pasture-700 px-6 py-3 text-center text-sm font-semibold text-farm-50 shadow transition-all duration-200 hover:bg-pasture-800"
                    >
                        Registrar Lote e Emitir O.S.
                    </button>

                </form>

            </div>

            <!-- COLUNA DIREITA: Regras operacionais e histórico -->
            <div class="flex flex-col gap-5">

                <!-- Regras de Negócio -->
                <div class="rounded-3xl border border-farm-300 bg-farm-100 p-6">

                    <h3 class="font-bold text-farm-900 mb-3">
                        Validações & Regras de Negócio
                    </h3>

                    <ul class="text-xs text-farm-700 flex flex-col gap-3">

                        <li class="flex items-start gap-2">
                            <span class="text-pasture-700 font-bold">1.</span>

                            <span>
                                <strong>Padrão de Umidade:</strong>
                                Só serão aceitos lotes de grãos com teor de umidade abaixo
                                de 14%. Valores superiores sofrem quebra no peso líquido.
                            </span>
                        </li>

                        <li class="flex items-start gap-2">
                            <span class="text-pasture-700 font-bold">2.</span>

                            <span>
                                <strong>Controle Sanitário:</strong>
                                O recebimento de gado exige a validação digital da Guia de
                                Transporte Animal (GTA) no sistema.
                            </span>
                        </li>

                        <li class="flex items-start gap-2">
                            <span class="text-pasture-700 font-bold">3.</span>

                            <span>
                                <strong>Classificação Técnica:</strong>
                                Os lotes passam por análise de qualidade antes da liberação
                                definitiva para armazenamento.
                            </span>
                        </li>

                    </ul>

                </div>

                <!-- Histórico Dinâmico -->
                <div class="rounded-3xl border border-farm-300 bg-farm-50 p-6">

                    <h4 class="text-sm font-bold text-farm-900 mb-3">
                        Últimos Registros do Terminal
                    </h4>

                    <div class="flex flex-col gap-3 text-xs text-farm-600">

                        @forelse($historico as $registro)

                            <div class="border-b border-farm-200 pb-2">

                                <p>
                                    <strong>{{ ucfirst($registro->safra_tipo) }}</strong>
                                    —
                                    {{ number_format($registro->safra_quantidade, 0, ',', '.') }}
                                </p>

                                <p>
                                    Cooperado:
                                    <em>{{ $registro->cooperado_nome }}</em>
                                </p>

                            </div>

                        @empty

                            <p>
                                Nenhum registro disponível no momento.
                            </p>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>

    </section>
@endsection