@extends('layouts.app')

@section('content')
<div class="container my-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <h1 class="fw-bold text-primary mb-3 mb-md-0">
            <i class="bi bi-box-seam me-2"></i>Lista de Produtos
        </h1>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('products.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Novo Produto
            </a>
            <a href="{{ route('reports.products') }}" class="btn btn-outline-primary shadow-sm">
                <i class="bi bi-file-earmark-bar-graph me-1"></i> Relatório de Produtos
            </a>
            <a href="{{ route('reports.users') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-people me-1"></i> Relatório de Usuários
            </a>
        </div>
    </div>

    <div class="table-responsive shadow-sm rounded-3">
        <table class="table table-hover align-middle mb-0 text-center">
            <thead class="table-primary align-middle">
                <tr>
                    <th>Título</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Conteúdo</th>
                    <th>Status</th>
                    <th style="width: 160px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr>
                    <td class="fw-semibold">{{ $product->titulo }}</td>
                    <td>R$ {{ number_format($product->preco, 2, ',', '.') }}</td>
                    <td>{{ $product->quantidade }}</td>
                    <td>{{ $product->conteudo ?: '-' }}</td>
                    <td>
                        @if($product->status == 1)
                        <span class="badge bg-success">Ativo</span>
                        @else
                        <span class="badge bg-danger">Inativo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm rounded-pill me-1 shadow-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-sm rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </td>
                </tr>
            <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $product->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="deleteModalLabel{{ $product->id }}">Confirmação</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">
                            Tem certeza que deseja excluir o produto <strong>{{ $product->titulo }}</strong>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Excluir</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="bi bi-inbox"></i> Nenhum produto cadastrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteModal = document.getElementById('confirmDeleteModal');
            const deleteForm = document.getElementById('deleteForm');
            const itemName = document.getElementById('itemName');

            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nome = button.getAttribute('data-nome');

                itemName.textContent = nome;
                deleteForm.action = `/produtos/${id}`;
            });
        });
    </script>
@endsection