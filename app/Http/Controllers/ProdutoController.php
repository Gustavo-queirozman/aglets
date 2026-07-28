<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    function index(){
        return Produto::all();
    }

    function create(){}

    function store(Request $request){}

    function show($id){}

    function edit($id){}

    function update(Request $request, $id){}

    function destroy($id){}
}
