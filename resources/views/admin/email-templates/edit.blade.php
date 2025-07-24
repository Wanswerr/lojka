@extends('layouts.admin')

@section('title', 'Editar Template de E-mail')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Editando: {{ $template->name }}</h1>
            <p class="text-muted mb-0">Ajuste o conteúdo do template.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="alert alert-info">
                <h5 class="alert-heading">Variáveis Disponíveis:</h5>
                <p class="mb-0">Use as seguintes variáveis no assunto e no corpo do e-mail: <code>@{{ NOME_CLIENTE }}</code>, <code>@{{ NUMERO_PEDIDO }}</code>, etc.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <h5 class="alert-heading">Ocorreram erros:</h5>
                    <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('admin.email-templates.update', $template->id) }}" method="POST" class="mt-3">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-12">
                        <label for="subject" class="form-label">Assunto do E-mail</label>
                        <input type="text" class="form-control" id="subject" name="subject" value="{{ old('subject', $template->subject) }}" required>
                    </div>
                    <div class="col-12">
                        <label for="body_html" class="form-label">Corpo do E-mail</label>
                        <textarea class="form-control" id="body_html" name="body_html" rows="15">{{ old('body_html', $template->body_html) }}</textarea>
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
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
        tinymce.init({
            selector: 'textarea#body_html',
            plugins: 'code table lists image link',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table | image link'
        });
    </script>
@endsection