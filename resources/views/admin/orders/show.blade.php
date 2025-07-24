@extends('layouts.admin')

@section('title', 'Detalhes do Pedido')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Detalhes do Pedido #{{ $order->id }}</h1>
            <p class="text-muted mb-0">Pedido realizado em {{ $order->created_at->format('d/m/Y \à\s H:i') }}</p>
        </div>
        <div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-2"></i>
                Voltar para Pedidos
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="table-container">
                <div class="table-header">
                    <h5 class="fw-semibold mb-1">Itens do Pedido</h5>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th class="text-center">Quantidade</th>
                                <th class="text-end">Preço Unitário</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $item->product->name ?? 'Produto não encontrado' }}</div>
                                        {{-- AQUI ESTÁ A MÁGICA --}}
                                        @if($item->deliveredKey)
                                            <div class="text-muted small mt-1 p-2 bg-light rounded">
                                                <strong>Entregue:</strong> <code>{{ $item->deliveredKey->key_data }}</code>
                                            </div>
                                        @else
                                            <div class="text-warning small mt-1">
                                                <strong>Entrega pendente</strong>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">R$ {{ number_format($item->price, 2, ',', '.') }}</td>
                                    <td class="text-end fw-bold">R$ {{ number_format($item->quantity * $item->price, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <th colspan="3" class="text-end">Total do Pedido:</th>
                                <th class="text-end h5 mb-0">R$ {{ number_format($order->total, 2, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="fw-semibold mb-1">Cliente</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nome:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                    <p class="mb-0"><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                    <a href="{{ route('admin.users.show', $order->user->id) }}" class="btn btn-sm btn-outline-primary mt-2">Ver Perfil do Cliente</a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="fw-semibold mb-1">Alterar Status</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="input-group">
                            <select name="status" class="form-select">
                                <option value="pending" @selected($order->status == 'pending')>Pendente</option>
                                <option value="paid" @selected($order->status == 'paid')>Pago</option>
                                <option value="shipped" @selected($order->status == 'shipped')>Enviado</option>
                                <option value="delivered" @selected($order->status == 'delivered')>Entregue</option>
                                <option value="canceled" @selected($order->status == 'canceled')>Cancelado</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection