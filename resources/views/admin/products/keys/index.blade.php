@extends('layouts.admin')

@section('title', 'Gerenciar Chaves/Contas')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            {{-- Usamos a variável $itemTypeName que o controller envia --}}
            <h1 class="h2 fw-bold mb-1">Gerenciar {{ $itemTypeName }}s</h1>
            <p class="text-muted mb-0">Para o produto: <strong>{{ $product->name }}</strong></p>
        </div>
        <div>
            <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-2"></i>
                Voltar para o Inventário
            </a>
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

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="fw-semibold mb-1">Adicionar Novas {{ $itemTypeName }}s</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small">Cole as chaves/contas abaixo, uma por linha. Linhas em branco serão ignoradas.</p>
                    <form action="{{ route('admin.products.keys.store', $product->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="keys" class="form-control" rows="8" placeholder="CHAVE-ABC-123&#10;login:senha&#10;CHAVE-GHI-789"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Adicionar {{ $itemTypeName }}s</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="table-container h-100">
                <div class="table-header">
                    <h5 class="fw-semibold mb-1">{{ $itemTypeName }}s Cadastradas ({{ $product->available_keys_count }} disponíveis)</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-sm mb-0">
                        <thead>
                            <tr>
                                <th>{{ $itemTypeName }}</th>
                                <th>Status</th>
                                <th width="50"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($keys as $key)
                                <tr>
                                    <td><code>{{ Str::limit($key->key_data, 50) }}</code></td>
                                    <td>
                                        @if($key->status == 'available')
                                            <span class="badge bg-success">Disponível</span>
                                        @else
                                            <span class="badge bg-danger">Vendido</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($key->status == 'available')
                                            <form action="{{ route('admin.products.keys.destroy', $key->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza?')"><i class="bi bi-trash"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center p-4">Nenhuma chave/conta cadastrada.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                 {{-- Paginação --}}
                <div class="p-3">
                    {{ $keys->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection