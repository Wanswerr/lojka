@extends('layouts.admin')

@section('title', 'Organizar Loja')

@section('styles')
{{-- Estilos específicos para esta página --}}
<style>
    .product-list {
        display: flex;
        gap: 10px;
        padding: 10px;
        overflow-x: auto;
        background-color: #f8f9fa;
        border-radius: 5px;
    }
    .product-item {
        flex-shrink: 0;
        width: 80px;
        height: 80px;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        cursor: grab;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .product-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .product-item .product-name {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(0,0,0,0.6);
        color: white;
        font-size: 10px;
        padding: 2px 4px;
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Organizar Loja</h1>
            <p class="text-muted mb-0">Arraste as categorias (verticalmente) e os produtos (horizontalmente) para definir a ordem de exibição.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus me-2"></i> Nova Categoria</a>
    </div>

    <div class="alert alert-info small"><i class="bi bi-info-circle me-2"></i>A ordem é salva automaticamente ao mover qualquer item.</div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="50"></th>
                        <th>Categoria</th>
                        <th>Produtos na Categoria (Arraste para ordenar)</th>
                        <th width="50"></th>
                    </tr>
                </thead>
                <tbody id="sortable-categories">
                    @forelse ($categories as $category)
                        <tr data-id="{{ $category->id }}">
                            <td style="cursor: grab;"><i class="bi bi-grip-vertical"></i></td>
                            <td>
                                <div class="fw-medium">{{ $category->name }}</div>
                                <div class="small text-muted">ID: {{ $category->id }}</div>
                            </td>
                            <td>
                                <div class="product-list" data-category-id="{{ $category->id }}">
                                    @forelse($category->products as $product)
                                        <div class="product-item" data-id="{{ $product->id }}">
                                            @if($product->image_path)
                                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}">
                                            @else
                                                <i class="bi bi-box h4 text-muted"></i>
                                            @endif
                                            <div class="product-name">{{ $product->name }}</div>
                                        </div>
                                    @empty
                                        <small class="text-muted">Nenhum produto nesta categoria.</small>
                                    @endforelse
                                </div>
                            </td>
                            <td>
                                {{-- Ações de Editar/Excluir Categoria --}}
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('admin.categories.edit', $category->id) }}"><i class="bi bi-pencil me-2"></i>Editar Categoria</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center p-4">Nenhuma categoria encontrada.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
{{-- Biblioteca SortableJS --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    // Função genérica para salvar a ordem via Fetch API
    function saveOrder(url, ids) {
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ ids: ids })
        })
        .then(response => response.json())
        .then(data => console.log('Ordem salva com sucesso!', data))
        .catch(error => console.error('Erro ao salvar a ordem:', error));
    }

    // --- LÓGICA PARA ORDENAR AS CATEGORIAS (VERTICAL) ---
    const categoriesList = document.getElementById('sortable-categories');
    if (categoriesList) {
        new Sortable(categoriesList, {
            animation: 150,
            handle: '.bi-grip-vertical',
            onEnd: function () {
                const categoryIds = Array.from(categoriesList.children).map(row => row.dataset.id);
                saveOrder('{{ route("admin.categories.reorder") }}', categoryIds);
            }
        });
    }

    // --- LÓGICA RESTAURADA PARA ORDENAR OS PRODUTOS (HORIZONTAL) ---
    document.querySelectorAll('.product-list').forEach(productList => {
        if (productList) {
            new Sortable(productList, {
                animation: 150,
                onEnd: function () {
                    const categoryId = productList.dataset.categoryId;
                    const productIds = Array.from(productList.children).map(item => item.dataset.id);
                    
                    const url = `/admin/categories/${categoryId}/products/reorder`;
                    
                    saveOrder(url, productIds);
                }
            });
        }
    });
</script>
@endsection