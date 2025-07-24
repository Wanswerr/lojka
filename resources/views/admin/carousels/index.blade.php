@extends('layouts.admin')

@section('title', 'Gerenciar Carrossel')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Gerenciar Carrossel</h1>
            <p class="text-muted mb-0">Adicione, ordene e edite os slides da página inicial.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.carousels.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus me-2"></i>
                Novo Slide
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-container">
        <div class="table-header">
            <h5 class="fw-semibold mb-1">Slides Atuais</h5>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Ordem</th>
                        <th>Imagem</th>
                        <th>Título</th>
                        <th>Status</th>
                        <th width="50"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($slides as $slide)
                        <tr>
                            <td class="fw-bold">{{ $slide->order }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $slide->image_path) }}" alt="{{ $slide->title }}" class="img-thumbnail" style="max-width: 150px;">
                            </td>
                            <td>
                                <div class="fw-medium">{{ $slide->title }}</div>
                                @if($slide->link_url)
                                    <div class="small text-muted">Link: {{ $slide->link_url }}</div>
                                @endif
                            </td>
                            <td>
                                @if($slide->is_active)
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-secondary">Inativo</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('admin.carousels.edit', $slide->id) }}"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.carousels.destroy', $slide->id) }}" method="POST">
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
                            <td colspan="5" class="text-center p-4">Nenhum slide encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection