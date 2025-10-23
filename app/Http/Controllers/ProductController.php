<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'preco' => str_replace(['.', ','], ['', '.'], $request->preco)
        ]);

        $request->validate([
            'titulo' => 'required',
            'preco' => 'required|numeric',
            'quantidade' => 'required|integer',
        ]);
        // print_r( $request->all());
        // sleep(100);
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
            'quantidade' => 'required|integer',
        ]);
       
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
            // Exclui o produto
            $product->delete();
            // Redireciona para a lista de produtos com mensagem de sucesso
            return redirect()->route('products.index')->with('success', 'Produto excluído com sucesso!');
        } catch (\Exception $e) {
            // Redireciona de volta com mensagem de erro
            return redirect()->back()->with('error', 'Erro ao excluir o produto: ' . $e->getMessage());
        }
    }
}
