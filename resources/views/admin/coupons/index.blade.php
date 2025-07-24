@extends('layouts.admin')

@section('title', 'Cupons de Desconto')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Cupons de Desconto</h1>
            <p class="text-muted mb-0">Gerencie seus códigos promocionais.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus me-2"></i>
                Novo Cupom
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-container">
        <div class="table-header">
            <h5 class="fw-semibold mb-1">Todos os Cupons</h5>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Expira em</th>
                        <th width="50"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($coupons as $coupon)
                        <tr>
                            <td><code class="fw-bold">{{ $coupon->code }}</code></td>
                            <td>{{ ucfirst($coupon->type) }}</td>
                            <td>
                                @if($coupon->type == 'fixed')
                                    R$ {{ number_format($coupon->value, 2, ',', '.') }}
                                @else
                                    {{ (int)$coupon->value }}%
                                @endif
                            </td>
                            <td>{{ $coupon->expires_at ? $coupon->expires_at->format('d/m/Y') : 'Não expira' }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('admin.coupons.edit', $coupon->id) }}"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST">
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
                            <td colspan="5" class="text-center p-4">Nenhum cupom encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginação --}}
    <div class="mt-4">
        {{ $coupons->links() }}
    </div>
@endsection