@extends('layouts.admin')

@section('title', 'Inventário')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Inventário</h1>
            <p class="text-muted mb-0">Rastreie e gerencie o inventário de Keys e Contas</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="stats-grid">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-2"><span class="fw-medium text-muted small">Total em Estoque</span><i class="bi bi-archive stat-icon"></i></div>
            <div class="stat-value">{{ number_format($totalStock) }}</div>
            <div class="stat-label">Itens disponíveis para venda</div>
        </div>
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-2"><span class="fw-medium text-muted small">Valor do Estoque</span><i class="bi bi-currency-dollar stat-icon"></i></div>
            <div class="stat-value">R$ {{ number_format($stockValue, 2, ',', '.') }}</div>
            <div class="stat-label">Valor total dos itens</div>
        </div>
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-2"><span class="fw-medium text-muted small">Produtos em Falta</span><i class="bi bi-exclamation-triangle text-danger stat-icon"></i></div>
            <div class="stat-value">{{ $outOfStockCount }}</div>
            <div class="stat-label">Produtos sem estoque</div>
        </div>
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-2"><span class="fw-medium text-muted small">Estoque Baixo</span><i class="bi bi-exclamation-circle text-warning stat-icon"></i></div>
            <div class="stat-value">{{ $lowStockCount }}</div>
            <div class="stat-label">Produtos com menos de 5 itens</div>
        </div>
    </div>

    <div class="table-container mt-4">
        <div class="table-header">
            <h5 class="fw-semibold mb-1">Gerenciamento de Itens</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">Itens Disponíveis</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td><strong>{{ $product->name }}</strong></td>
                            <td class="text-center"><span class="badge bg-light text-dark">{{ ucfirst($product->type) }}</span></td>
                            <td class="text-center fs-5">
                                <span class="badge bg-{{ $product->available_keys_count > 0 ? 'success' : 'danger' }}">{{ $product->available_keys_count }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.products.keys.index', $product->id) }}" class="btn btn-sm btn-info">
                                    Gerenciar {{ $product->type == 'key' ? 'Keys' : 'Contas' }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center p-4">Nenhum produto encontrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $products->links() }}</div>


    <div class="chart-container mt-4">
        <div class="mb-3">
            <h5 class="fw-semibold mb-1">Movimentações Recentes</h5>
            <p class="text-muted small mb-0">Últimas entradas e saídas de estoque</p>
        </div>
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr><th>Data</th><th>Produto</th><th>Tipo</th><th>Quantidade</th><th>Motivo</th><th>Usuário</th></tr>
                </thead>
                <tbody>
                    @forelse($recentMovements as $movement)
                    <tr>
                        <td>{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $movement->product->name ?? 'N/A' }}</td>
                        <td>
                            @if($movement->quantity_change > 0)
                                <span class="badge bg-success">Entrada</span>
                            @else
                                <span class="badge bg-danger">Saída</span>
                            @endif
                        </td>
                        <td class="fw-bold">{{ $movement->quantity_change > 0 ? '+' : '' }}{{ $movement->quantity_change }}</td>
                        <td>{{ $movement->reason }}</td>
                        <td>{{ $movement->admin->name ?? 'Sistema' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Nenhuma movimentação recente.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection