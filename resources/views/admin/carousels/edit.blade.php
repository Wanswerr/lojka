@extends('layouts.admin')

@section('title', 'Editar Slide')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Editar Slide</h1>
            <p class="text-muted mb-0">Atualize os dados do slide.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif

            <form action="{{ route('admin.carousels.update', $carousel->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-12">
                        <label for="image_path" class="form-label">Nova Imagem (opcional)</label>
                        <input type="file" class="form-control" id="image_path" name="image_path">
                        <div class="form-text">Envie uma nova imagem apenas se quiser substituir a atual.</div>
                        <div class="mt-2">
                            <p class="small text-muted mb-1">Imagem Atual:</p>
                            <img src="{{ asset('storage/' . $carousel->image_path) }}" alt="{{ $carousel->title }}" class="img-thumbnail" style="max-width: 250px;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="title" class="form-label">Título</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $carousel->title) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="subtitle" class="form-label">Subtítulo (opcional)</label>
                        <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ old('subtitle', $carousel->subtitle) }}">
                    </div>
                    <div class="col-12">
                        <label for="link_url" class="form-label">Link (opcional)</label>
                        <input type="url" class="form-control" id="link_url" name="link_url" value="{{ old('link_url', $carousel->link_url) }}" placeholder="https://exemplo.com/produto">
                    </div>
                    <div class="col-md-6">
                        <label for="order" class="form-label">Ordem de Exibição</label>
                        <input type="number" class="form-control" id="order" name="order" value="{{ old('order', $carousel->order) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="is_active" class="form-label">Status</label>
                        <select class="form-select" id="is_active" name="is_active">
                            <option value="1" @selected(old('is_active', $carousel->is_active) == 1)>Ativo</option>
                            <option value="0" @selected(old('is_active', $carousel->is_active) == 0)>Inativo</option>
                        </select>
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        <a href="{{ route('admin.carousels.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection