@extends('layouts.admin')

@section('title', 'Novo Template de E-mail')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Novo Template de E-mail</h1>
            <p class="text-muted mb-0">Crie um novo template a partir de um tipo pré-definido.</p>
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

            <form action="{{ route('admin.email-templates.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="email_template_type_id" class="form-label">Tipo de Template</label>
                        <select class="form-select" id="email_template_type_id" name="email_template_type_id" required>
                            <option value="">-- Selecione um tipo --</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" data-type-key="{{ $type->type_key }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nome do Template</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Ex: Promoção de Natal" required>
                    </div>
                    <div class="col-12">
                        <label for="subject" class="form-label">Assunto</label>
                        <input type="text" class="form-control" id="subject" name="subject" value="{{ old('subject') }}" required>
                    </div>
                    <div class="col-12">
                        <label for="body_html" class="form-label">Corpo do E-mail</label>
                        <textarea class="form-control" id="body_html" name="body_html" rows="15">{{ old('body_html') }}</textarea>
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">Salvar Template</button>
                        <a href="{{ route('admin.email-templates.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        // O script para preencher os campos com conteúdo padrão continua o mesmo
        const defaultTemplates = { /* ... (seu objeto defaultTemplates aqui) ... */ };
        
        // O event listener para o select também continua o mesmo
        
        tinymce.init({
            selector: 'textarea#body_html',
            plugins: 'code table lists image link',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table | image link'
        });
    </script>
@endsection