<header class="top-header">
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center flex-grow-1">
            <button class="btn btn-link mobile-toggle me-3" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <div class="search-container">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="form-control search-input" placeholder="Pesquisar...">
            </div>
        </div>
        
        <div class="d-flex align-items-center gap-3">
            {{-- Dropdown de Notificações --}}
            <div class="dropdown">
                <button class="btn btn-outline-secondary position-relative" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell"></i>
                    @if(isset($unreadCount) && $unreadCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-end p-0" style="width: 320px;">
                    <div class="p-2 border-bottom">
                        <h6 class="mb-0">Notificações</h6>
                    </div>
                    <div class="list-group list-group-flush" style="max-height: 400px; overflow-y: auto;">
                        @if(isset($notifications) && $notifications->count() > 0)
                            @foreach($notifications as $notification)
                            <a href="{{ route('admin.notifications.read', $notification->id) }}" class="list-group-item list-group-item-action">
                                <div class="small fw-bold">{{ $notification->data['message'] ?? 'Notificação inválida' }}</div>
                                <div class="small text-muted">{{ $notification->created_at->diffForHumans() }}</div>
                            </a>
                            @endforeach
                        @else
                            <div class="p-3 text-center text-muted small">Nenhuma nova notificação.</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Dropdown do Usuário --}}
            <div class="d-flex align-items-center gap-2">
                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <span class="text-white fw-bold" style="font-size: 12px;">{{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 2)) }}</span>
                </div>
                <span class="fw-medium d-none d-lg-block">{{ Auth::guard('admin')->user()->name }}</span>
                
                {{-- Formulário de Logout --}}
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link text-muted p-0" title="Sair">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>