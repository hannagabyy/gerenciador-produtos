@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body px-4 py-4">

      
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary">
                    <i class="bi bi-pencil-square me-2"></i>Editar Produto
                </h2>
            </div>

           
            <form action="{{ route('products.update', $product->id) }}" method="POST" 
                class="row g-3 justify-content-center needs-validation" novalidate>
                @csrf
                @method('PUT')

                <div class="col-md-6">
                    <label for="titulo" class="form-label fw-semibold">Título:</label>
                    <input type="text" name="titulo" id="titulo" 
                        class="form-control text-center" 
                        value="{{ old('titulo', $product->titulo) }}" required>
                </div>

                <div class="col-md-6">
                    <label for="preco" class="form-label fw-semibold">Preço:</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="text" name="preco" id="preco" 
                            class="form-control text-center" 
                            value="{{ old('preco', $product->preco) }}" required>
                        <div class="invalid-feedback">
                            Campo obrigatório.
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="quantidade" class="form-label fw-semibold">Quantidade:</label>
                    <input type="number" name="quantidade" id="quantidade" 
                        class="form-control text-center" 
                        value="{{ old('quantidade', $product->quantidade) }}" required>
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label fw-semibold">Status:</label>
                    <select name="status" id="status" class="form-select text-center">
                        <option value="1" {{ $product->status ? 'selected' : '' }}>Ativo</option>
                        <option value="0" {{ !$product->status ? 'selected' : '' }}>Inativo</option>
                    </select>
                </div>

                <div class="col-12">
                    <label for="conteudo" class="form-label fw-semibold">Conteúdo:</label>
                    <textarea name="conteudo" id="conteudo" 
                        class="form-control text-center" rows="3">{{ old('conteudo', $product->conteudo) }}</textarea>
                </div>

                <div class="col-12 text-center mt-4">
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        <i class="bi bi-check-circle me-1"></i> Atualizar Produto
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary ms-2">
                        <i class="bi bi-arrow-left"></i> Voltar
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>
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
