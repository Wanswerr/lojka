@extends('layouts.admin')

@section('title', 'Editar Categoria')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Editar Categoria</h1>
            <p class="text-muted mb-0">Atualize os dados da categoria: {{ $category->name }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif

            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nome da Categoria</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                    </div>

                    <div class="col-12">
                    <label for="image_path" class="form-label">Nova Imagem da Categoria</label>
                    <input type="file" class="form-control" id="image_path" name="image_path">
                    @if($category->image_path)
                        <div class="mt-2">
                            <p class="small text-muted mb-1">Imagem Atual:</p>
                            <img src="{{ asset('storage/' . $category->image_path) }}" alt="{{ $category->name }}" class="img-thumbnail" style="max-width: 150px;">
                        </div>
                    @endif
                </div>
                    <div class="col-md-6">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" required>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Script para auto-gerar o slug
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    nameInput.addEventListener('keyup', function() {
        const nameValue = this.value.trim().toLowerCase();
        const slugValue = nameValue.normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
        slugInput.value = slugValue;
    });
</script>
@endsection