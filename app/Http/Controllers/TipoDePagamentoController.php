<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormaPagamentoRequest;
use App\Http\Requests\FormaPagamentoUpdateRequest;
use App\Models\TipoDePagamento;
use Illuminate\Http\Request;

class TipoDePagamentoController extends Controller
{
    public function tipoPagamento(FormaPagamentoRequest $request)
    {
        $originalStatus = $request->status;
        $statusText = $request->status ? 'Ativado' : 'Desativado';
    
        $tipoPagamento = TipoDePagamento::create([
            'nome' => $request->nome,
            'taxa' => $request->taxa,
            'status' => $originalStatus 
        ]);
    
        return response()->json([
            "success" => true,
            "message" => "Métodos de Pagamento Adicionado",
            "data" => [
                'nome' => $tipoPagamento->nome,
                'taxa' => $tipoPagamento->taxa,
                'status' => $statusText 
            ]
        ], 200);
    }



    public function excluirPagamento($id)
    {
        $pagamento = TipoDePagamento::find($id);

        if (!isset($pagamento)) {
            return response()->json([
                'status' => false,
                'message' => "Pagamento não encontrado"
            ]);
        }
        $pagamento->delete();
        return response()->json([
            'status' => true,
            'message' => "Pagamento excluído com sucesso"
        ]);
    }

    public function updatePagamento(FormaPagamentoUpdateRequest $request)
    {
        $pagamento = TipoDePagamento::find($request->id);

        if (!isset($pagamento)) {
            return response()->json([
                'status' => false,
                'message' => "Pagamento não encontrado"
            ]);
        }
        if (isset($request->nome)) {
            $pagamento->nome = $request->nome;
        }
        if (isset($request->taxa)) {
            $pagamento->taxa = $request->taxa;
        }
        if (isset($request->status)) {
            $pagamento->status = $request->status;
        }
        $pagamento->update();

        return response()->json([
            'status' => true,
            'message' => 'Tipo de Pagamento Atualizado'
        ]);
    }

    public function retornarTodos(Request $request)
    {

        $pagamento = TipoDePagamento::all();
        return response()->json([
            'status' => true,
            'data' => $pagamento
        ]);
    }
}
