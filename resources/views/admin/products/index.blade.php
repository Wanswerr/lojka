@extends('layouts.admin')

@section('title', 'Produtos')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Produtos</h1>
            <p class="text-muted mb-0">Gerencie seu catálogo de produtos e inventário</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus me-2"></i>
                Adicionar Produto
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="filter-section mb-4">
        <form action="{{ route('admin.products.index') }}" method="GET">
            <div class="filter-row">
                <div class="filter-group">
                    <label class="form-label">Pesquisar produtos</label>
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #6b7280;"></i>
                        <input type="text" class="form-control" name="search" placeholder="Nome do produto..." style="padding-left: 40px;" value="{{ $search ?? '' }}">
                    </div>
                </div>
                
                <div class="filter-group">
                    <label class="form-label">Categoria</label>
                    <select class="form-select" name="category">
                        <option value="">Todas as Categorias</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected($category->id == ($categoryFilter ?? ''))>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="">Todos os Status</option>
                        <option value="active" @selected(($statusFilter ?? '') == 'active')>Ativo</option>
                        <option value="inactive" @selected(($statusFilter ?? '') == 'inactive')>Inativo</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <button type="submit" class="btn btn-primary" style="margin-top: 32px;">
                        <i class="bi bi-funnel"></i> Filtrar
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h5 class="fw-semibold mb-1">Todos os Produtos</h5>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="50"><input type="checkbox" class="form-check-input"></th>
                        <th>Produto</th>
                        <th>Tipo</th>
                        <th>Categoria</th>
                        <th>Preço</th>
                        <th>Estoque</th>
                        <th>Status</th>
                        <th width="50"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td><input type="checkbox" class="form-check-input"></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="product-icon me-3">
                                        @if($product->image_path)
                                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <i class="bi bi-box"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-medium">{{ $product->name }}</div>
                                        <div class="small text-muted">{{ $product->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ ucfirst($product->type) }}</td>
                            <td>
                                @foreach($product->categories as $category)
                                    <span class="badge bg-light text-dark">{{ $category->name }}</span>
                                @endforeach
                            </td>
                            <td class="fw-medium">R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                            <td>
                                <span class="{{ $product->available_keys_count < 10 ? 'text-warning fw-medium' : '' }}">
                                    {{ $product->available_keys_count }}
                                </span>
                            </td>
                            <td>
                                @if($product->is_active)
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Ativo</span>
                                @else
                                    <span class="badge bg-secondary"><i class="bi bi-x-circle me-1"></i> Inativo</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('admin.products.edit', $product->id) }}"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Tem certeza?')">
                                                    <i class="bi bi-trash me-2"></i>Excluir
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center p-4">Nenhum produto encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginação --}}
    <div class="mt-4">
        {{ $products->links() }}
    </div>
@endsection