<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductApiController extends Controller
{
    
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'success' => true,
            'products' => $products
        ], 200);
    }

   
    public function show(Product $product)
    {
        return response()->json([
            'success' => true,
            'product' => $product
        ], 200);
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'preco' => 'required|numeric',
            'quantidade' => 'required|integer|min:0',
            'status' => 'sometimes|boolean'
        ], [
            'quantidade.min' => 'A quantidade não pode ser menor que zero.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Produto criado com sucesso!',
            'product' => $product
        ], 201);
    }

    
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'preco' => 'required|numeric',
            'quantidade' => 'required|integer|min:0',
            'status' => 'sometimes|boolean'
        ], [
            'quantidade.min' => 'A quantidade não pode ser menor que zero.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $product->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Produto atualizado com sucesso!',
            'product' => $product
        ], 200);
    }

    
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produto excluído com sucesso!'
        ], 200);
    }
    
}
