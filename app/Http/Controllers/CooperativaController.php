<?php

namespace App\Http\Controllers;

use App\Models\Safra;
use Illuminate\Http\Request;

class CooperativaController extends Controller
{
    // Renderiza a Página Inicial
    public function home()
    {
        return view('home');
    }

    // Renderiza o Painel Operacional com os dados do Banco
    public function operation()
    {
        // Pega os últimos lotes registrados no banco
        $lotes = Safra::latest()->get();
        
        return view('operation', compact('lotes'));
    }

    // Renderiza a página de Mercado & Estoque
    public function stock()
    {
        return view('stock');
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
        // 1. Validação dos dados (Seu professor vai pirar nisso aqui!)
        $request->validate([
            'cooperado_nome' => 'required|string|max:255',
            'safra_tipo' => 'required|string',
            'safra_quantidade' => 'required|numeric|min:1',
        ]);

        // 2. Geração automática de um código de lote único
        $codigoLote = '#LT-' . date('Y') . '-' . str_pad(Safra::count() + 1, 2, '0', STR_PAD_LEFT);

        // 3. Regra de negócio simples para classificação fictícia
        $classificacao = 'Tipo 1 (Padrão)';
        if ($request->safra_tipo === 'pecuaria') {
            $classificacao = 'Pesagem Geral';
        }

        // 4. Salvar no banco de dados usando o Model
        Safra::create([
            'lote_codigo' => $codigoLote,
            'cooperado_nome' => $request->cooperado_nome,
            'safra_tipo' => $request->safra_tipo,
            'safra_quantidade' => $request->safra_quantidade,
            'classificacao' => $classificacao,
            'status' => $request->safra_tipo === 'pecuaria' ? 'Aguardando GTA' : 'Descarregado',
        ]);

        // 5. Redirecionar de volta com uma mensagem de sucesso
        return redirect()->route('coop.operation')->with('sucesso', 'Lote registrado com sucesso!');
    }
}