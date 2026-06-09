{{-- 
    Eu, João Victor, estou criando essa atividade de Cooperativa Agropecuária para a aula de PWIII.
    Este arquivo define o Layout Principal do sistema utilizando @extends e @section.
    
    COMENTÁRIO TÉCNICO: O menu superior foi construído utilizando uma estrutura de repetição (@foreach)
    sobre um array associativo. A diretiva @class do Blade valida dinamicamente se a rota atual 
    é a ativa através do método request()->routeIs(), aplicando as cores de destaque de forma limpa.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>@yield('title', 'AgroCoop') | {{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-farm-50 font-sans text-farm-900 antialiased">
        <div class="flex min-h-screen flex-col">
            
            <header class="border-b border-farm-200 bg-farm-100">
                <nav class="mx-auto flex w-full max-w-6xl flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between lg:px-8" aria-label="Navegacao principal">
                    
                    <a href="{{ route('coop.home') }}" class="inline-flex items-center gap-3 rounded-2xl border border-farm-300 bg-farm-50 px-4 py-2 text-sm font-semibold text-farm-900 transition-colors duration-200 hover:border-pasture-500 hover:bg-pasture-50">
                        <span class="flex size-9 items-center justify-center rounded-xl bg-barn-600 text-sm font-bold text-farm-50">AC</span>
                        <span>AgroCoop</span>
                    </a>

                    <div class="flex flex-wrap gap-2">
                        @foreach ([
                            ['label' => 'Início', 'route' => 'coop.home'],
                            ['label' => 'Cooperados & Safras', 'route' => 'coop.operation'],
                            ['label' => 'Mercado & Estoque', 'route' => 'coop.stock'],
                            ['label' => 'Enviar Relatório', 'route' => 'coop.report'],
                        ] as $item)
                            <a
                                href="{{ route($item['route']) }}"
                                @class([
                                    'rounded-xl border px-4 py-2 text-sm font-medium transition-colors duration-200',
                                    'border-pasture-500 bg-pasture-100 text-pasture-900' => request()->routeIs($item['route']),
                                    'border-transparent text-farm-700 hover:border-farm-300 hover:bg-farm-50 hover:text-farm-900' => ! request()->routeIs($item['route']),
                                ])
                            >
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </div>
                </nav>
            </header>

            <main class="flex-1">
                @yield('content')
            </main>

            <footer class="border-t border-farm-300 bg-farm-900 text-farm-100">
                <div class="mx-auto flex w-full max-w-6xl flex-col gap-3 px-5 py-6 text-sm sm:flex-row sm:items-center sm:justify-between lg:px-8">
                    <p>AgroCoop &copy; {{ date('Y') }} - Atividade Acadêmica para PWIII.</p>
                    <p>Gestão integrada de safras, pecuária e apoio ao pequeno produtor.</p>
                </div>
            </footer>
        </div>
    </body>
</html>