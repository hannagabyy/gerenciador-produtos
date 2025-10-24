<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {

         if ($request->expectsJson()) {
            return response()->json(Product::all());
        }
        
        return view('products.index', ['products' => Product::all()]);
        
    }

    public function store(Request $request)
    {
    

        $request->merge([
            'preco' => str_replace(['.', ','], ['', '.'], $request->preco)
        ]);

        $request->validate([
            'titulo' => 'required',
            'preco' => 'required|numeric',
            'quantidade' => 'required|integer|min:0',
        ],
        [
            'quantidade.min' => 'A quantidade não pode ser menor que zero.',
        ],
        );
        
        try {
            
           
            Product::create($request->all());

            return redirect()->route('products.index')->with('success', 'Produto criado com sucesso!');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Erro ao criar o produto: ' . $e->getMessage())->withInput();
        }
    }

    public function create()
    {
        return view('products.create');
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function update(Request $request, Product $product)
    {
        $request->merge([
            'preco' => str_replace(['.', ','], ['', '.'], $request->preco)
        ]);

        $request->validate([
            'titulo' => 'required',
            'preco' => 'required|numeric',
            'quantidade' => 'required|integer|min:0',
        ],
        [
            'quantidade.min' => 'A quantidade não pode ser menor que zero.',
        ],
        );
       
        try {
            $product->update($request->all());

            return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso!');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Erro ao atualizar o produto: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Product $product)
    {

        return view('products.edit', compact('product'));
    }

    public function destroy(Product $product)
    {
        try {
            
            $product->delete();
            
            return redirect()->route('products.index')->with('success', 'Produto excluído com sucesso!');
        } catch (\Exception $e) {
            
            return redirect()->back()->with('error', 'Erro ao excluir o produto: ' . $e->getMessage());
        }
    }
}
