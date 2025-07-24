@extends('layouts.admin')

@section('title', 'Analytics')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Analytics</h1>
            <p class="text-muted mb-0">Análise detalhada do desempenho da sua loja.</p>
        </div>
        {{-- Formulário de Filtro de Período --}}
        <form action="{{ route('admin.analytics.index') }}" method="GET" id="periodForm">
            <select name="period" class="form-select" onchange="document.getElementById('periodForm').submit();">
                <option value="last_30_days" @selected($period == 'last_30_days')>Últimos 30 dias</option>
                <option value="this_month" @selected($period == 'this_month')>Este Mês</option>
                <option value="last_7_days" @selected($period == 'last_7_days')>Últimos 7 dias</option>
                <option value="today" @selected($period == 'today')>Hoje</option>
            </select>
        </form>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-medium text-muted small">Receita no Período</span>
                <i class="bi bi-currency-dollar stat-icon"></i>
            </div>
            <div class="stat-value">R$ {{ number_format($revenue, 2, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-medium text-muted small">Pedidos no Período</span>
                <i class="bi bi-cart stat-icon"></i>
            </div>
            <div class="stat-value">{{ $ordersCount }}</div>
        </div>
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-medium text-muted small">Novos Clientes no Período</span>
                <i class="bi bi-people stat-icon"></i>
            </div>
            <div class="stat-value">{{ $newCustomersCount }}</div>
        </div>
    </div>
    
    <div class="placeholder-container mt-5">
        <div class="placeholder-icon">
            <i class="bi bi-bar-chart"></i>
        </div>
        <h3 class="placeholder-title">Mais Relatórios em Breve</h3>
        <p class="placeholder-text">Gráficos detalhados, relatórios de produtos e muito mais serão adicionados aqui.</p>
    </div>
@endsection