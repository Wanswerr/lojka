@extends('layouts.admin')

@section('title', 'Configurações')

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="h2 fw-bold mb-1">Configurações</h1>
                <p class="text-muted mb-0">Configure preferências e configurações da loja</p>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="bi bi-check me-2"></i>
                    Salvar Alterações
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row g-4">
            <div class="col-12 col-lg-3">
                <div class="list-group" id="settings-tabs">
                    <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#general">
                        <i class="bi bi-gear me-2"></i> Geral
                    </a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#tracking">
                        <i class="bi bi-graph-up-arrow me-2"></i> Rastreamento
                    </a>
                    {{-- Abas futuras --}}
                    <a class="list-group-item list-group-item-action disabled" data-bs-toggle="list" href="#payments-settings">
                        <i class="bi bi-credit-card me-2"></i> Pagamentos
                    </a>
                     <a class="list-group-item list-group-item-action disabled" data-bs-toggle="list" href="#security">
                        <i class="bi bi-shield-check me-2"></i> Segurança
                    </a>
                </div>
            </div>
            
            <div class="col-12 col-lg-9">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="general">
                        <div class="chart-container">
                            <h5 class="fw-semibold mb-3">Configurações Gerais da Loja</h5>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Logo do Site</label>
                                    <input type="file" class="form-control" name="site_logo">
                                    @if(isset($settings['site_logo']))
                                        <div class="mt-2">
                                            <p class="small text-muted mb-1">Logo Atual:</p>
                                            <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo Atual" style="max-height: 60px; background-color: #f8f9fa; padding: 5px; border-radius: 5px;">
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Texto do Rodapé</label>
                                    <textarea class="form-control" name="footer_text" rows="3">{{ old('footer_text', $settings['footer_text'] ?? '') }}</textarea>
                                </div>
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="maintenance_mode" name="maintenance_mode" value="1"
                                               @checked(old('maintenance_mode', $settings['maintenance_mode'] ?? 0))>
                                        <label class="form-check-label" for="maintenance_mode">Ativar modo manutenção</label>
                                        <div class="form-text">Quando ativo, apenas administradores logados poderão ver o site.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tracking">
                        <div class="chart-container">
                            <h5 class="fw-semibold mb-3">Pixels e Analytics</h5>
                             <div class="row g-3">
                                <div class="col-12">
                                    <label for="google_analytics_id" class="form-label">Google Analytics ID</label>
                                    <input type="text" class="form-control" name="google_analytics_id" 
                                           value="{{ old('google_analytics_id', $settings['google_analytics_id'] ?? '') }}" 
                                           placeholder="G-XXXXXXXXXX">
                                </div>
                                <div class="col-12">
                                    <label for="facebook_pixel_id" class="form-label">Facebook Pixel ID</label>
                                    <input type="text" class="form-control" name="facebook_pixel_id"
                                           value="{{ old('facebook_pixel_id', $settings['facebook_pixel_id'] ?? '') }}"
                                           placeholder="Seu ID do Pixel">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection