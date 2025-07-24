@extends('layouts.admin')

@section('title', 'Novo Slide')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Novo Slide</h1>
            <p class="text-muted mb-0">Preencha os dados para adicionar um novo slide ao carrossel.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif

            <form action="{{ route('admin.carousels.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label for="image_path" class="form-label">Imagem do Slide</label>
                        <input type="file" class="form-control" id="image_path" name="image_path" required>
                        <div class="form-text">A imagem será o fundo do slide. Escolha uma de boa qualidade (ex: 1920x1080).</div>
                    </div>
                    <div class="col-md-6">
                        <label for="title" class="form-label">Título</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="subtitle" class="form-label">Subtítulo (opcional)</label>
                        <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ old('subtitle') }}">
                    </div>
                    <div class="col-12">
                        <label for="link_url" class="form-label">Link (opcional)</label>
                        <input type="url" class="form-control" id="link_url" name="link_url" value="{{ old('link_url') }}" placeholder="https://exemplo.com/produto">
                    </div>
                    <div class="col-md-6">
                        <label for="order" class="form-label">Ordem de Exibição</label>
                        <input type="number" class="form-control" id="order" name="order" value="{{ old('order', 0) }}" required>
                        <div class="form-text">Slides com números menores aparecem primeiro.</div>
                    </div>
                    <div class="col-md-6">
                        <label for="is_active" class="form-label">Status</label>
                        <select class="form-select" id="is_active" name="is_active">
                            <option value="1" @selected(old('is_active', 1) == 1)>Ativo</option>
                            <option value="0" @selected(old('is_active') == 0)>Inativo</option>
                        </select>
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">Salvar Slide</button>
                        <a href="{{ route('admin.carousels.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection