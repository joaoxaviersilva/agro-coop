{{-- 
    Eu, João Victor, estou criando essa atividade de Cooperativa Agropecuária para a aula de PWIII.
    Este arquivo define a nova tela de Edição de Lote Operacional utilizando as diretivas do Blade.
--}}

@extends('layouts.app')

@section('title', 'Editar Lote Operacional')

@section('content')
    <section class="mx-auto w-full max-w-xl px-5 py-12 lg:px-8">
        
        <div class="mb-6">
            <a href="{{ route('coop.operation') }}" class="text-sm font-bold text-farm-600 hover:underline">← Voltar para Painel de Operações</a>
            <h1 class="mt-2 text-3xl font-bold text-farm-900">Modificar Registro de Carga</h1>
            <p class="text-sm text-farm-700">Alteração dos dados cadastrais do lote físico {{ $lote->lote_codigo }}</p>
        </div>

        <div class="rounded-3xl border border-farm-300 bg-farm-50 p-6 shadow-sm">
            <form action="{{ route('coop.update', $lote->id) }}" method="POST" class="flex flex-col gap-5">
                @csrf
                @method('PUT')

                <!-- Produtor / Cooperado -->
                <div class="flex flex-col gap-1">
                    <label for="cooperado_nome" class="text-sm font-bold text-farm-800">Nome do Cooperado / Produtor</label>
                    <input type="text" name="cooperado_nome" id="cooperado_nome" value="{{ $lote->cooperado_nome }}" required
                           class="w-full rounded-xl border border-farm-300 bg-white px-4 py-2 text-sm text-farm-900 shadow-inner focus:border-pasture-500 focus:outline-none focus:ring-1 focus:ring-pasture-500">
                </div>

                <!-- Tipo de Cultura e Volumetria -->
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="flex flex-col gap-1">
                        <label for="safra_tipo" class="text-sm font-bold text-farm-800">Cultura Agrícola</label>
                        <select name="safra_tipo" id="safra_tipo" required
                                class="w-full rounded-xl border border-farm-300 bg-white px-4 py-2 text-sm text-farm-900 focus:border-pasture-500 focus:outline-none focus:ring-1 focus:ring-pasture-500">
                            <option value="milho" {{ $lote->safra_tipo == 'milho' ? 'selected' : '' }}>Milho</option>
                            <option value="soja" {{ $lote->safra_tipo == 'soja' ? 'selected' : '' }}>Soja</option>
                            <option value="trigo" {{ $lote->safra_tipo == 'trigo' ? 'selected' : '' }}>Trigo</option>
                            <option value="pecuaria" {{ $lote->safra_tipo == 'pecuaria' ? 'selected' : '' }}>Pecuária (Cabeças)</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label for="safra_quantidade" class="text-sm font-bold text-farm-800">Volume (kg / cab)</label>
                        <input type="number" name="safra_quantidade" id="safra_quantidade" value="{{ $lote->safra_quantidade }}" required min="1"
                               class="w-full rounded-xl border border-farm-300 bg-white px-4 py-2 text-sm text-farm-900 shadow-inner focus:border-pasture-500 focus:outline-none focus:ring-1 focus:ring-pasture-500">
                    </div>
                </div>

                <!-- Status Operacional do Fluxo -->
                <div class="flex flex-col gap-1">
                    <label for="status" class="text-sm font-bold text-farm-800">Status Técnico do Pátio</label>
                    <select name="status" id="status" required
                            class="w-full rounded-xl border border-farm-300 bg-white px-4 py-2 text-sm text-farm-900 focus:border-pasture-500 focus:outline-none focus:ring-1 focus:ring-pasture-500">
                        <option value="Descarregado" {{ $lote->status == 'Descarregado' ? 'selected' : '' }}>Descarregado / Concluído</option>
                        <option value="Aguardando GTA" {{ $lote->status == 'Aguardando GTA' ? 'selected' : '' }}>Aguardando GTA (Pecuária)</option>
                        <option value="Em Triagem" {{ $lote->status == 'Em Triagem' ? 'selected' : '' }}>Em Triagem / Pátio</option>
                    </select>
                </div>

                <!-- Botões de Ação do Form -->
                <div class="mt-2 flex justify-end gap-3">
                    <a href="{{ route('coop.operation') }}" class="rounded-xl border border-farm-300 bg-white px-5 py-2 text-sm font-bold text-farm-700 hover:bg-farm-100 transition">Cancelar</a>
                    <button type="submit" class="rounded-xl bg-pasture-700 px-5 py-2 text-sm font-bold text-white hover:bg-pasture-800 shadow-sm transition">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </section>
@endsection