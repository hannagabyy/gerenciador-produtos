@extends('layouts.app')

@section('content')

    <h1 class="mb-4">Lista de Produtos</h1>
     <!-- Exibir mensagens de sucesso -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <!-- Exibir mensagens de erro -->
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-5 mr-2">Novo Produto</a>
    

     <a href="{{ route('reports.products') }}" class="btn btn-secondary mb-5">Relatório de Produtos em Estoque</a>
     <a href="{{ route('reports.users') }}" class="btn btn-secondary mb-5">Relatório de Usuários</a>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Título</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Conteudo</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->titulo }}</td>
                    <td>R$ {{ $product->preco }}</td> 
                    <td>{{ $product->quantidade }}</td>
                    <td>{{ $product->conteudo ?: '-'}}</td>
                    <td> @if($product->status == 1)
                            <span class="text-success">Ativo</span> 
                        @else
                            <span class="text-danger">Inativo</span> 
                        @endif</td>
                    <td>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este produto?');">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

 
@endsection

