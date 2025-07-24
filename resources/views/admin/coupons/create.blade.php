@extends('layouts.admin')

@section('title', 'Novo Cupom')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Novo Cupom</h1>
            <p class="text-muted mb-0">Crie um novo código promocional para sua loja.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('admin.coupons.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="code" class="form-label">Código</label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" required>
                        <div class="form-text">Ex: PROMO10, NATAL2025. Use letras maiúsculas e números.</div>
                    </div>
                    <div class="col-md-6">
                        <label for="type" class="form-label">Tipo de Desconto</label>
                        <select class="form-select" name="type" id="type">
                            <option value="fixed" @selected(old('type') == 'fixed')>Valor Fixo (R$)</option>
                            <option value="percentage" @selected(old('type') == 'percentage')>Porcentagem (%)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="value" class="form-label">Valor</label>
                        <input type="number" class="form-control" id="value" name="value" step="0.01" value="{{ old('value') }}" required>
                        <div class="form-text">Para porcentagem, insira apenas o número (ex: 10 para 10%).</div>
                    </div>
                    <div class="col-md-6">
                        <label for="expires_at" class="form-label">Data de Expiração (opcional)</label>
                        <input type="date" class="form-control" id="expires_at" name="expires_at" value="{{ old('expires_at') }}">
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">Salvar Cupom</button>
                        <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection