{{-- 
    Eu, João Victor, estou criando essa atividade de Cooperativa Agropecuária para a aula de PWIII.
    Este arquivo define a tela personalizada de Erro 404 utilizando @extends e @section.
    
    COMENTÁRIO TÉCNICO: Esta view foi atualizada para incluir um identificador numérico massivo (404),
    melhorando a experiência do usuário (UX) através de um forte feedback visual. O layout utiliza
    classes de text-size extremas do Tailwind (text-7xl/sm:text-9xl) de forma totalmente responsiva.
--}}

@extends('layouts.app')

@section('title', 'Página não Encontrada')

@section('content')
    <section class="mx-auto flex min-h-[75vh] w-full max-w-4xl flex-col items-center justify-center gap-6 px-5 py-12 text-center lg:px-8">
        
        <div class="select-none font-black tracking-tighter text-barn-600 opacity-20 text-7xl sm:text-9xl">
            404
        </div>

        <div class="rounded-xl border border-barn-300 bg-barn-50 px-4 py-2 text-sm font-semibold text-barn-800 shadow-sm animate-bounce">
            ⚠️ Aviso do Sistema
        </div>

        <div class="flex flex-col gap-5 rounded-3xl border border-farm-300 bg-farm-100 p-8 shadow-sm">
            <h1 class="text-3xl font-bold leading-tight text-farm-900 sm:text-4xl">
                Caminho Inexistente
            </h1>
            <p class="mx-auto max-w-2xl text-base leading-7 text-farm-700">
                Essa rota não está mapeada nos silos ou piquetes da AgroCoop. Use o menu superior ou os botões abaixo para retornar à sede principal.
            </p>
        </div>

        <div class="flex flex-wrap justify-center gap-3 mt-2">
            <a href="{{ route('coop.home') }}" class="rounded-2xl border border-pasture-700 bg-pasture-700 px-5 py-3 text-sm font-semibold text-farm-50 transition-colors duration-200 hover:bg-pasture-800 shadow">
                Voltar à Sede (Início)
            </a>
            <a href="{{ route('coop.operation') }}" class="rounded-2xl border border-farm-300 bg-farm-100 px-5 py-3 text-sm font-semibold text-farm-900 transition-colors duration-200 hover:bg-barn-50">
                Checar Operações
            </a>
        </div>
        
    </section>
@endsection