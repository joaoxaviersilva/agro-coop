<?php

namespace App\Http\Controllers;

use App\Models\Safra;
use Illuminate\Http\Request;

class CooperativaController extends Controller
{
    // Renderiza a Página Inicial
    public function home()
    {
        // Soma a quantidade de KG no banco e divide por 1000 para converter em toneladas
        $totalMilho = Safra::where('safra_tipo', 'milho')->sum('safra_quantidade') / 1000;
        $totalSoja = Safra::where('safra_tipo', 'soja')->sum('safra_quantidade') / 1000;
        $totalTrigo = Safra::where('safra_tipo', 'trigo')->sum('safra_quantidade') / 1000;

        // Pecuária representa cabeças, então não dividimos por 1000
        $totalPecuaria = Safra::where('safra_tipo', 'pecuaria')->sum('safra_quantidade');

        // Verifica se existe algum lote de pecuária retido ou aguardando documentação
        $hasPendenciaPecuaria = Safra::where('safra_tipo', 'pecuaria')
                                     ->where('status', 'Aguardando GTA')
                                     ->exists();

        return view('home', compact('totalMilho', 'totalSoja', 'totalTrigo', 'totalPecuaria', 'hasPendenciaPecuaria'));
    }

    // Renderiza o Painel Operacional com os dados do Banco
    public function operation()
    {
        // 1. Carrega todos os lotes em ordem decrescente
        $lotes = Safra::latest()->get();
        
        // 2. LÓGICA DOS SILOS: Soma o total de grãos (em kg) para monitorar capacidade
        $totalGraosEstoque = Safra::whereIn('safra_tipo', ['milho', 'soja', 'trigo'])->sum('safra_quantidade');

        // Silo 01 recebe os primeiros 150.000 kg. Se passar disso, ele lota.
        $statusSilo01 = $totalGraosEstoque >= 150000 ? 'Capacidade Limite' : 'Disponível';
        
        // Silo 02 só começa a lotar de verdade se o estoque total passar de 300.000 kg.
        $statusSilo02 = $totalGraosEstoque >= 300000 ? 'Capacidade Limite' : 'Disponível';

        // 3. LÓGICA DO FRIGORÍFICO: Monitora se há pendência de GTA ativa no pátio
        $hasPendenciaPecuaria = Safra::where('safra_tipo', 'pecuaria')
                                     ->where('status', 'Aguardando GTA')
                                     ->exists();
        $statusFrigorifico = $hasPendenciaPecuaria ? 'Retido / Triagem' : 'Manejo OK';

        return view('operation', compact('lotes', 'statusSilo01', 'statusSilo02', 'statusFrigorifico'));
    }

    // Renderiza a página de Mercado & Estoque (INTEGRADA AO BANCO)
    public function stock()
    {
        // 1. CÁLCULO SILO NORTE (Grãos - em Toneladas)
        $totalGraosTon = Safra::whereIn('safra_tipo', ['milho', 'soja', 'trigo'])->sum('safra_quantidade') / 1000;
        $capacidadeMaximaNorte = 150; // Limite técnico de toneladas definido para o projeto
        
        // Regra para não estourar a barra do layout caso passe de 100%
        $porcentagemNorte = min(($totalGraosTon / $capacidadeMaximaNorte) * 100, 100);

        // 2. CÁLCULO SILO SUL (Pecuária - em Cabeças)
        $totalPecuariaCab = Safra::where('safra_tipo', 'pecuaria')->sum('safra_quantidade');
        $capacidadeMaximaSul = 20000; // Limite técnico de cabeças para o projeto
        
        $porcentagemSul = min(($totalPecuariaCab / $capacidadeMaximaSul) * 100, 100);

        return view('stock', compact(
            'totalGraosTon', 
            'capacidadeMaximaNorte', 
            'porcentagemNorte', 
            'totalPecuariaCab', 
            'capacidadeMaximaSul', 
            'porcentagemSul'
        ));
    }

    // Renderiza o formulário de envio técnico
    public function report()
    {
        // Pega apenas os 3 últimos registros para o mini-histórico lateral
        $historico = Safra::latest()->take(3)->get();

        return view('report', compact('historico'));
    }

    // Processa o envio do formulário e salva no Banco de Dados
    public function storeReport(Request $request)
    {
        $request->validate([
            'cooperado_nome' => 'required|string|max:255',
            'safra_tipo' => 'required|string',
            'safra_quantidade' => 'required|numeric|min:1',
        ]);

        $codigoLote = '#LT-' . date('Y') . '-' . str_pad(Safra::count() + 1, 2, '0', STR_PAD_LEFT);

        $classificacao = 'Tipo 1 (Padrão)';
        if ($request->safra_tipo === 'pecuaria') {
            $classificacao = 'Pesagem Geral';
        }

        Safra::create([
            'lote_codigo' => $codigoLote,
            'cooperado_nome' => $request->cooperado_nome,
            'safra_tipo' => $request->safra_tipo,
            'safra_quantidade' => $request->safra_quantidade,
            'classificacao' => $classificacao,
            'status' => $request->safra_tipo === 'pecuaria' ? 'Aguardando GTA' : 'Descarregado',
        ]);

        return redirect()->route('coop.operation')->with('sucesso', 'Lote registrado com sucesso!');
    }

    // [CRUD - UPDATE] Exibe a tela de edição preenchida com o lote selecionado
    public function edit($id)
    {
        $lote = Safra::findOrFail($id);
        return view('edit', compact('lote'));
    }

    // [CRUD - UPDATE] Salva as alterações feitas no lote operacional
    public function update(Request $request, $id)
    {
        $request->validate([
            'cooperado_nome' => 'required|string|max:255',
            'safra_tipo' => 'required|string',
            'safra_quantidade' => 'required|numeric|min:1',
            'status' => 'required|string'
        ]);

        $lote = Safra::findOrFail($id);

        // Recalcula classificação caso a cultura mude
        $classificacao = $request->safra_tipo === 'pecuaria' ? 'Pesagem Geral' : 'Tipo 1 (Padrão)';

        $lote->update([
            'cooperado_nome' => $request->cooperado_nome,
            'safra_tipo' => $request->safra_tipo,
            'safra_quantidade' => $request->safra_quantidade,
            'classificacao' => $classificacao,
            'status' => $request->status,
        ]);

        return redirect()->route('coop.operation')->with('sucesso', 'Registro de lote atualizado com sucesso!');
    }

    // [CRUD - DELETE] Remove fisicamente o lote do banco de dados
    public function destroy($id)
    {
        $lote = Safra::findOrFail($id);
        $lote->delete();

        return redirect()->route('coop.operation')->with('sucesso', 'O lote foi removido do sistema operacional!');
    }
}