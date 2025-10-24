@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body px-4 py-4">

            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary">
                    <i class="bi bi-box-seam me-2"></i>Criar Novo Produto
                </h2>
            </div>

            <form action="{{ route('products.store') }}" method="POST" 
                  class="row g-3 justify-content-center needs-validation" novalidate>
                @csrf

                <div class="col-md-6">
                    <label for="titulo" class="form-label fw-semibold">Título: *</label>
                    <input type="text" name="titulo" id="titulo" 
                           class="form-control text-center" required>
                    <div class="invalid-feedback text-center">
                        Campo obrigatório.
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="preco" class="form-label fw-semibold">Preço: *</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="text" name="preco" id="preco" 
                               class="form-control text-center" required>
                        <div class="invalid-feedback text-center">
                            Campo obrigatório.
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="quantidade" class="form-label fw-semibold">Quantidade: *</label>
                    <input type="number" min="0" name="quantidade" id="quantidade" 
                           class="form-control text-center" required>
                    <div class="invalid-feedback text-center">
                        Campo obrigatório.
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label fw-semibold">Status:</label>
                    <select name="status" id="status" class="form-select text-center">
                        <option value="1" selected>Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                </div>

                <div class="col-12">
                    <label for="conteudo" class="form-label fw-semibold">Conteúdo:</label>
                    <textarea name="conteudo" id="conteudo" 
                              class="form-control text-center" rows="3"></textarea>
                </div>

                <div class="col-12 text-center mt-4">
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        <i class="bi bi-plus-circle me-1"></i> Criar Produto
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
        $('#preco').mask('000.000.000.000.000,00', {reverse: true});
    });
</script>
@endsection
