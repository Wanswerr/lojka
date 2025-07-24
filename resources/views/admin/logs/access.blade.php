@extends('layouts.admin')

@section('title', 'Logs de Acesso')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Logs de Acesso</h1>
            <p class="text-muted mb-0">Histórico de logins no painel administrativo.</p>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h5 class="fw-semibold mb-1">Registros de Login</h5>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Administrador</th>
                        <th>Endereço IP</th>
                        <th>Ação</th>
                        <th>Data e Hora</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td><strong>#{{ $log->id }}</strong></td>
                            <td>
                                @if($log->admin)
                                <div class="d-flex align-items-center">
                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                        <span class="text-white fw-bold small">{{ strtoupper(substr($log->admin->name, 0, 2)) }}</span>
                                    </div>
                                    <span class="fw-medium">{{ $log->admin->name }}</span>
                                </div>
                                @else
                                    <span class="text-muted">Admin Excluído</span>
                                @endif
                            </td>
                            <td><code>{{ $log->ip_address }}</code></td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $log->action }}</span>
                            </td>
                            <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-4">Nenhum log de acesso encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginação --}}
    <div class="mt-4">
        {{ $logs->links() }}
    </div>
@endsection