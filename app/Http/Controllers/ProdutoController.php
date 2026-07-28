<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtualizarProduto;
use App\Http\Requests\MostrarProduto;
use App\Http\Requests\SalvarProduto;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    function index(){
        $produtos = Produto::all();
        return response()->json($produtos, 200);
    }

    //function create(){}

    function store(SalvarProduto $request){
        $produto = Produto::create($request->validated());
        return response()->json($produto, 200);
    }

    function show(MostrarProduto $request){
        $produto = Produto::findOrFail($request->id);
        return response()->json($produto, 200);
    }

    //function edit($id){}

    function update(AtualizarProduto $request, $id){
        $produto = Produto::findOrFail($id);
        $produto->update($request->validated());
        return response()->json($produto, 200);
    }

    function destroy($id){
        $produto = Produto::findOrFail($id);
        $produto->delete();
        return response()->json(['message' => 'Produto excluído com sucesso'], 200);
    }
}
