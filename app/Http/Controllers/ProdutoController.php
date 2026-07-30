<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtualizarProduto;
use App\Http\Requests\ListarProdutosRequest;
use App\Http\Requests\SalvarProduto;
use App\Http\Resources\ProdutoResource;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(ListarProdutosRequest $request)
    {
        $produtos = Produto::listarComCache($request->filtros());

        return response()->json([
            'message' => 'Lista de produtos',
            'produtos' => ProdutoResource::collection($produtos)->resolve($request),
        ], 200);
    }

    public function store(SalvarProduto $request)
    {
        $produto = Produto::create($request->validated());

        return response()->json([
            'message' => 'Produto criado com sucesso',
            'produto' => ProdutoResource::make($produto)->resolve($request),
        ], 201);
    }

    public function show(Request $request, int $id)
    {
        $produto = Produto::findOrFail($id);

        return response()->json([
            'message' => 'Produto encontrado com sucesso',
            'produto' => ProdutoResource::make($produto)->resolve($request),
        ], 200);
    }

    public function update(AtualizarProduto $request, int $id)
    {
        $produto = Produto::findOrFail($id);
        $produto->update($request->validated());

        return response()->json([
            'message' => 'Produto atualizado com sucesso',
            'produto' => ProdutoResource::make($produto)->resolve($request),
        ], 200);
    }

    public function destroy(int $id)
    {
        $produto = Produto::findOrFail($id);
        $produto->delete();

        return response()->json(['message' => 'Produto excluido com sucesso'], 200);
    }
}
