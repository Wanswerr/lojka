@extends('layouts.admin')

@section('title', 'Templates de E-mail')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Templates de E-mail</h1>
            <p class="text-muted mb-0">Gerencie o conteúdo dos e-mails automáticos da loja.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.email-templates.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus me-2"></i>
                Novo Template
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-container">
        <div class="table-header">
            <h5 class="fw-semibold mb-1">Templates Cadastrados</h5>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Nome do Template</th>
                        <th>Tipo</th>
                        <th>Assunto</th>
                        <th width="50"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($templates as $template)
                        <tr>
                            <td>
                                <div class="fw-medium">{{ $template->name }}</div>
                                <div class="small text-muted">ID: {{ $template->id }}</div>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $template->emailTemplateType?->name }}</span>
                            </td>
                            <td>{{ $template->subject }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('admin.email-templates.edit', $template->id) }}"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.email-templates.destroy', $template->id) }}" method="POST">
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
                            <td colspan="4" class="text-center p-4">Nenhum template de e-mail encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection