<?php

namespace App\Http\Controllers;

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

    function show($id){}

    //function edit($id){}

    function update(Request $request, $id){}

    function destroy($id){}
}
