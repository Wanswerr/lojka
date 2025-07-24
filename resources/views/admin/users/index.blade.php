@extends('layouts.admin')

@section('title', 'Clientes')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Clientes</h1>
            <p class="text-muted mb-0">Gerencie contas de clientes e dados de usuários.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus me-2"></i>
                Adicionar Cliente
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="filter-section mb-4">
        <form action="{{ route('admin.users.index') }}" method="GET">
            <div class="filter-row">
                <div class="filter-group">
                    <label class="form-label">Pesquisar Clientes</label>
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #6b7280;"></i>
                        <input type="text" class="form-control" name="search" placeholder="Nome ou email do cliente..." style="padding-left: 40px;" value="{{ $search ?? '' }}">
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
             <h5 class="fw-semibold mb-1">Todos os Clientes</h5>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="50"><input type="checkbox" class="form-check-input"></th>
                        <th>Cliente</th>
                        <th>Contato</th>
                        <th>Data de Cadastro</th>
                        <th>Total de Pedidos</th>
                        <th width="50"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td><input type="checkbox" class="form-check-input"></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="product-icon me-3">
                                        {{-- Simples inicial do nome como avatar --}}
                                        <span class="fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-medium">{{ $user->name }}</div>
                                        <div class="small text-muted">ID: {{ $user->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="small">{{ $user->email }}</div>
                            </td>
                            <td>
                                <div class="small">{{ $user->created_at->format('d/m/Y') }}</div>
                            </td>
                            <td>
                                {{-- Contamos os pedidos carregados --}}
                                <span class="badge bg-light text-dark">{{ $user->orders_count }}</span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('admin.users.show', $user->id) }}"><i class="bi bi-eye me-2"></i>Ver Detalhes</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.users.edit', $user->id) }}"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
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
                            <td colspan="6" class="text-center p-4">Nenhum cliente encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginação --}}
    <div class="mt-4">
        {{ $users->links() }}
    </div>
@endsection