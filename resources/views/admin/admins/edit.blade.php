@extends('layouts.admin')

@section('title', 'Editar Membro da Equipe')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Editar Membro: {{ $admin->name }}</h1>
            <p class="text-muted mb-0">Atualize os dados do administrador.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                     <h5 class="alert-heading">Ocorreram erros:</h5>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $admin->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $admin->email) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">Nova Senha</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <div class="form-text">Deixe em branco para não alterar.</div>
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                     <div class="col-12">
                        <label class="form-label">Papéis (Roles)</label>
                        <div class="border rounded p-2">
                            @foreach($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}"
                                        @checked($admin->roles->contains($role))
                                        @if($admin->id === 1 && $role->name === 'Super Admin') disabled @endif>
                                    <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection