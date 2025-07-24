@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Dashboard</h1>
            <p class="text-muted mb-0">Bem-vindo(a) de volta, {{ Auth::guard('admin')->user()->name }}!</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-center mb-2"><span class="fw-medium text-muted small">Receita Total</span><i class="bi bi-currency-dollar metric-icon"></i></div>
                <div class="metric-value">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-center mb-2"><span class="fw-medium text-muted small">Pedidos (Pagos)</span><i class="bi bi-cart metric-icon"></i></div>
                <div class="metric-value">{{ $totalOrders }}</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-center mb-2"><span class="fw-medium text-muted small">Clientes</span><i class="bi bi-people metric-icon"></i></div>
                <div class="metric-value">{{ $totalCustomers }}</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-center mb-2"><span class="fw-medium text-muted small">Produtos Ativos</span><i class="bi bi-box metric-icon"></i></div>
                <div class="metric-value">{{ $activeProducts }}</div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-8">
            <div class="chart-container">
                <h5 class="fw-semibold mb-1">Visão Geral das Vendas</h5>
                <p class="text-muted small mb-3">Receita diária dos últimos 30 dias</p>
                <div style="height: 280px;"><canvas id="salesChart"></canvas></div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="chart-container">
                <h5 class="fw-semibold mb-1">Vendas por Categoria</h5>
                <div style="height: 280px;"><canvas id="categoryChart"></canvas></div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <div class="chart-container" style="height: auto;">
                <h5 class="fw-semibold mb-1">Top Produtos</h5>
                <div id="topProducts">
                    @forelse($topProducts as $product)
                        <div class="product-item">
                            <div class="d-flex align-items-center"><div class="product-icon"><i class="bi bi-box text-muted"></i></div><div><div class="fw-medium">{{ $product->name }}</div><div class="small text-muted">{{ $product->total_sold }} Vendas</div></div></div>
                        </div>
                    @empty
                        <p class="text-muted">Nenhum dado disponível.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="chart-container" style="height: auto;">
                <h5 class="fw-semibold mb-1">Pedidos Recentes</h5>
                <div id="recentOrders">
                    @forelse($recentOrders as $order)
                        <div class="order-item">
                            <div><div class="fw-medium">#{{$order->id}}</div><div class="small text-muted">{{ $order->user->name ?? 'N/A' }}</div></div>
                            <div class="text-end"><div class="fw-medium">R${{number_format($order->total, 2, ',', '.')}}</div><span class="status-badge status-{{$order->status}}">{{ ucfirst($order->status) }}</span></div>
                        </div>
                    @empty
                         <p class="text-muted">Nenhum pedido recente.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Já tínhamos este script, que carrega a biblioteca Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    {{-- Este script chama as nossas funções do dashboard.js e passa os dados do Laravel --}}
    <script>
        // Quando a página carregar, chame as funções de inicialização dos gráficos
        document.addEventListener('DOMContentLoaded', function() {
            // A variável salesData é criada aqui, usando os dados do controller
            const salesData = @json($salesOverTime);
            initSalesChart(salesData);

            // A variável categoryData é criada aqui
            const categoryData = @json($salesByCategory);
            initCategoryChart(categoryData);
        });
    </script>
@endsection