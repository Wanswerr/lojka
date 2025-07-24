@extends('layouts.admin')

@section('title', 'Adicionar Produto')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Adicionar Novo Produto</h1>
            <p class="text-muted mb-0">Preencha os dados do novo produto.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <h5 class="alert-heading">Ocorreram erros:</h5>
                    <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="account"> {{-- ou 'key', dependendo da lógica que definimos --}}
                
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome do Produto</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea class="form-control" id="description" name="description" rows="5">{{ old('description') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image_path" class="form-label">Imagem do Produto</label>
                            <input type="file" class="form-control" id="image_path" name="image_path">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Preço (R$)</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ old('price') }}" required>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select class="form-select" id="is_active" name="is_active">
                                <option value="1" @selected(old('is_active', 1) == 1)>Ativo</option>
                                <option value="0" @selected(old('is_active') == 0)>Inativo</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Categorias</label>
                            <div class="relationship-box">
                                @forelse ($categories as $category)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat_{{ $category->id }}">
                                        <label class="form-check-label" for="cat_{{ $category->id }}">{{ $category->name }}</label>
                                    </div>
                                @empty
                                    <p class="small text-muted">Nenhuma categoria cadastrada.</p>
                                @endforelse
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email_template_id" class="form-label">E-mail de Entrega (Opcional)</label>
                            <select class="form-select" id="email_template_id" name="email_template_id">
                                <option value="">-- Nenhum --</option>
                                @foreach($deliveryTemplates as $template)
                                    <option value="{{ $template->id }}">{{ $template->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Salvar Produto</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancelar</a>
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