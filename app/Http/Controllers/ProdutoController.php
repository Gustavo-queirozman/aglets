<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtualizarProduto;
use App\Http\Requests\SalvarProduto;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();

        return response()->json(['message' => 'Lista de produtos', 'produtos' => $produtos], 200);
    }

    public function store(SalvarProduto $request)
    {
        $produto = Produto::create($request->validated());

        return response()->json(['message' => 'Produto criado com sucesso', 'produto' => $produto], 201);
    }

    public function show(Produto $produto)
    {
        return response()->json(['message' => 'Produto encontrado com sucesso', 'produto' => $produto], 200);
    }

    public function update(AtualizarProduto $request, Produto $produto)
    {
        $produto->update($request->validated());

        return response()->json(['message' => 'Produto atualizado com sucesso', 'produto' => $produto], 200);
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();

        return response()->json(['message' => 'Produto excluido com sucesso'], 200);
    }
}
