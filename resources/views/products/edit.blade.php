@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Editar Produto</h1>
    
    <form action="{{ route('products.update', $product->id) }}" method="POST" class="row needs-validation" novalidate>
        @csrf
        @method('PUT') 
        
        <div class="form-group col-md-6">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo', $product->titulo) }}" required>
        </div>
        
         <div class="form-group col-md-6">
            <label for="preco">Preço:</label>
            <div class="input-group">
                <div class="input-group-text">R$</div>
                <input type="text" name="preco" id="preco" class="form-control" value="{{ old('preco', $product->preco) }}" required>
                <div class="invalid-feedback">
                 Campo obrigatório.
                </div>
            </div>
        </div>
        
        <div class="form-group col-md-6">
            <label for="quantidade">Quantidade:</label>
            <input type="number" name="quantidade" id="quantidade" class="form-control" value="{{ old('quantidade', $product->quantidade) }}" required>
        </div>
        
        <div class="form-group col-md-6">
            <label for="status">Status:</label>
            <select name="status" id="status" class="form-select">
                <option value="1" {{ $product->status ? 'selected' : '' }}>Ativo</option>
                <option value="0" {{ !$product->status ? 'selected' : '' }}>Inativo</option>
            </select>
        </div>
        
        <div class="form-group col-12 mb-4">
            <label for="conteudo">Conteúdo:</label>
            <textarea name="conteudo" id="conteudo" class="form-control" rows="3">{{ old('conteudo', $product->conteudo) }}</textarea>
        </div>
        
        <div class="form-group col-12">
            <button type="submit" class="btn btn-primary">Atualizar Produto</button>
        </div>
    </form>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        var precoValue = $('#preco').val();
        if (precoValue && !isNaN(precoValue)) {
            precoValue = precoValue.replace('.', ',');
            $('#preco').val(precoValue);
        }
        
        $('#preco').mask('000.000.000.000.000,00', {reverse: true});
    });


</script>
@endsection
