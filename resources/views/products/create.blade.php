@extends('layouts.app')

@section('content')


    <h1 class="mb-4">Criar Novo Produto</h1>
    
    <form action="{{ route('products.store') }}" method="POST" class="row needs-validation" novalidate>
        @csrf
        
        <div class="form-group col-md-6">
            <label for="titulo">Título: *</label>
            <input type="text" name="titulo" id="titulo" class="form-control" required>
            <div class="invalid-feedback">
                 Campo obrigatório.
            </div>
        </div>
        
        <div class="form-group col-md-6">
            <label for="preco">Preço:*</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">R$</span>
                </div>
                <input type="text" name="preco" id="preco" class="form-control" required>
                 <div class="invalid-feedback">
                 Campo obrigatório.
                </div>
            </div>
        </div>
        
        <div class="form-group col-md-6">
            <label for="quantidade">Quantidade: *</label>
            <input type="number" name="quantidade" id="quantidade" class="form-control" required>
            <div class="invalid-feedback">
                 Campo obrigatório.
            </div>
        </div>
        
        <div class="form-group col-md-6">
            <label for="status">Status:</label>
            <select name="status" id="status" class="form-control">
                <option value="1">Ativo</option>
                <option value="0">Inativo</option>
            </select>
        </div>
        
        <div class="form-group col-12 mb-4">
            <label for="conteudo">Conteúdo:</label>
            <textarea name="conteudo" id="conteudo" class="form-control" rows="3"></textarea>
        </div>
        
        <div class="form-group col-12">
            <button type="submit" class="btn btn-primary">Criar Produto</button>
        </div>
    </form>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('#preco').mask('000.000.000.000.000,00', {reverse: true});
    });

    

</script>
@endsection