@extends('layouts.admin')

@section('title', 'Equipe')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Equipe</h1>
            <p class="text-muted mb-0">Gerencie contas de funcionários e permissões.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.admins.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus me-2"></i>
                Adicionar Membro
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-container">
        <div class="table-header">
            <h5 class="fw-semibold mb-1">Membros da Equipe</h5>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="50"><input type="checkbox" class="form-check-input"></th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Papéis (Roles)</th>
                        <th width="50"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($admins as $admin)
                        <tr>
                            <td><input type="checkbox" class="form-check-input"></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                        <span class="text-white fw-bold small">{{ strtoupper(substr($admin->name, 0, 2)) }}</span>
                                    </div>
                                    <span class="fw-medium">{{ $admin->name }}</span>
                                </div>
                            </td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                @foreach($admin->roles as $role)
                                    @php
                                        $roleClass = $role->name === 'Super Admin' ? 'bg-danger text-white' : 'bg-warning text-dark';
                                    @endphp
                                    <span class="badge {{ $roleClass }}">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('admin.admins.edit', $admin->id) }}"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                                        @if(auth('admin')->user()->id !== $admin->id && $admin->id !== 1)
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Tem certeza?')">
                                                        <i class="bi bi-trash me-2"></i>Excluir
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-4">Nenhum membro da equipe encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginação --}}
    <div class="mt-4">
        {{ $admins->links() }}
    </div>
@endsection