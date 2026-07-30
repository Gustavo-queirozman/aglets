<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtualizarProduto;
use App\Http\Requests\ListarProdutosRequest;
use App\Http\Requests\SalvarProduto;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index(ListarProdutosRequest $request)
    {
        $produtos = Produto::query()
            ->filtrar($request->filtros())
            ->get();

        return response()->json(['message' => 'Lista de produtos', 'produtos' => $produtos], 200);
    }

    public function store(SalvarProduto $request)
    {
        $produto = Produto::create($request->validated());

        return response()->json(['message' => 'Produto criado com sucesso', 'produto' => $produto], 201);
    }

    public function show(int $id)
    {
        $produto = Produto::findOrFail($id);

        return response()->json(['message' => 'Produto encontrado com sucesso', 'produto' => $produto], 200);
    }

    public function update(AtualizarProduto $request, int $id)
    {
        $produto = Produto::findOrFail($id);
        $produto->update($request->validated());

        return response()->json(['message' => 'Produto atualizado com sucesso', 'produto' => $produto], 200);
    }

    public function destroy(int $id)
    {
        $produto = Produto::findOrFail($id);
        $produto->delete();

        return response()->json(['message' => 'Produto excluido com sucesso'], 200);
    }
}
