@extends('layouts.admin')

@section('title', 'Pedidos')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Pedidos</h1>
            <p class="text-muted mb-0">Gerencie pedidos de clientes e cumprimento</p>
        </div>
        {{-- Futuramente, podemos adicionar um botão de "Novo Pedido" aqui se necessário --}}
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="stats-grid mb-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-2"><span class="fw-medium text-muted small">Total de Pedidos</span><i class="bi bi-cart stat-icon"></i></div>
            <div class="stat-value">{{ $orders->total() }}</div>
            <div class="stat-label">Pedidos no total</div>
        </div>
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-2"><span class="fw-medium text-muted small">Pendentes</span><i class="bi bi-clock text-warning stat-icon"></i></div>
            <div class="stat-value">{{ $pendingCount }}</div>
            <div class="stat-label">Aguardando processamento</div>
        </div>
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-2"><span class="fw-medium text-muted small">Pagos</span><i class="bi bi-check-circle text-success stat-icon"></i></div>
            <div class="stat-value">{{ $paidCount }}</div>
            <div class="stat-label">Pedidos pagos</div>
        </div>
    </div>

    <div class="filter-section mb-4">
        <form action="{{ route('admin.orders.index') }}" method="GET">
            <div class="filter-row">
                <div class="filter-group">
                    <label class="form-label">Pesquisar Pedidos</label>
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #6b7280;"></i>
                        <input type="text" class="form-control" name="search" placeholder="ID do pedido, nome ou email do cliente..." style="padding-left: 40px;" value="{{ $search ?? '' }}">
                    </div>
                </div>
                <div class="filter-group">
                    <button type="submit" class="btn btn-primary" style="margin-top: 32px;">Pesquisar</button>
                </div>
            </div>
        </form>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h5 class="fw-semibold mb-1">Todos os Pedidos</h5>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="50"><input type="checkbox" class="form-check-input"></th>
                        <th>Pedido</th>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th width="50"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td><input type="checkbox" class="form-check-input"></td>
                            <td>
                                <div>
                                    <div class="fw-medium">#{{ $order->id }}</div>
                                    <div class="small text-muted">{{ $order->items->count() }} item(s)</div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div class="fw-medium">{{ $order->user->name ?? 'Cliente Excluído' }}</div>
                                    <div class="small text-muted">{{ $order->user->email ?? '-' }}</div>
                                </div>
                            </td>
                            <td><div class="small">{{ $order->created_at->format('d/m/Y H:i') }}</div></td>
                            <td class="fw-medium">R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                            <td>
                                @php
                                    $statusClass = '';
                                    switch($order->status) {
                                        case 'paid': $statusClass = 'bg-success'; break;
                                        case 'pending': $statusClass = 'bg-warning text-dark'; break;
                                        case 'canceled': $statusClass = 'bg-danger'; break;
                                        case 'shipped': $statusClass = 'bg-primary'; break;
                                        case 'delivered': $statusClass = 'bg-info text-dark'; break;
                                        default: $statusClass = 'bg-secondary'; break;
                                    }
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center p-4">Nenhum pedido encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginação --}}
    <div class="mt-4">
        {{ $orders->links() }}
    </div>
@endsection