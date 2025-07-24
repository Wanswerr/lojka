@extends('layouts.admin')

@section('title', 'Detalhes do Cliente')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Detalhes do Cliente</h1>
            <p class="text-muted mb-0">Informações detalhadas e histórico de {{ $user->name }}.</p>
        </div>
        <div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-2"></i>
                Voltar para a Lista
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <span class="text-white fw-bold h2">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                    </div>
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <p class="text-muted">{{ $user->email }}</p>
                    <p class="text-muted small">Cliente desde: {{ $user->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <div class="stat-card mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-medium text-muted small">Receita Total Gerada</span>
                    <i class="bi bi-currency-dollar stat-icon"></i>
                </div>
                <div class="stat-value text-success">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</div>
            </div>
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-medium text-muted small">Total de Pedidos</span>
                    <i class="bi bi-cart stat-icon"></i>
                </div>
                <div class="stat-value">{{ $user->orders->count() }}</div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="table-container mb-4">
                <div class="table-header">
                    <h5 class="fw-semibold mb-1">Histórico de Compras</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr><th>#Pedido</th><th>Data</th><th>Valor</th><th>Status</th><th></th></tr>
                        </thead>
                        <tbody>
                            @forelse ($user->orders as $order)
                                <tr>
                                    <td><strong>#{{ $order->id }}</strong></td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                                    <td><span class="badge bg-info text-dark">{{ ucfirst($order->status) }}</span></td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center p-3">Este cliente ainda não fez nenhuma compra.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="table-container">
                <div class="table-header">
                    <h5 class="fw-semibold mb-1">Carrinho Abandonado</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr><th>Produto</th><th>Qtd.</th><th>Preço Unit.</th><th>Subtotal</th></tr>
                        </thead>
                        <tbody>
                            @if ($abandonedCart && $abandonedCart->items->isNotEmpty())
                                @foreach ($abandonedCart->items as $item)
                                    <tr>
                                        <td>{{ $item->product->name ?? 'Produto não encontrado' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>R$ {{ number_format($item->product->price ?? 0, 2, ',', '.') }}</td>
                                        <td>R$ {{ number_format(($item->product->price ?? 0) * $item->quantity, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="4" class="text-center p-3">O cliente não possui um carrinho abandonado.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection