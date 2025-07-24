<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="bi bi-box"></i>
        </div>
        <h5 class="brand-text">EcomAdmin</h5>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav flex-column">
            {{-- Links Principais --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-house"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.orders.index') }}">
                    <i class="bi bi-cart"></i> Pedidos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.products.index') }}">
                    <i class="bi bi-box"></i> Produtos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.categories.index') }}">
                <i class="bi bi-folder2-open"></i> Categorias
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people"></i> Clientes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.inventory.index') }}">
                    <i class="bi bi-archive"></i> Inventário
                </a>
            </li>
            
            {{-- Gerenciamento de Conteúdo e Marketing --}}
            <li class="nav-item mt-3"><small class="text-muted px-3">Conteúdo & Marketing</small></li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.carousels.index') }}">
                    <i class="bi bi-images"></i> Carrossel
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.coupons.index') }}">
                    <i class="bi bi-tag"></i> Cupons
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.email-templates.index') }}">
                    <i class="bi bi-envelope-paper"></i> Templates de E-mail
                </a>
            </li>

            {{-- Administração --}}
            <li class="nav-item mt-3"><small class="text-muted px-3">Administração</small></li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.analytics.index') }}">
                    <i class="bi bi-bar-chart"></i> Analytics
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.admins.index') }}">   
                    <i class="bi bi-person-check"></i> Equipe (Admins)
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.logs.access') }}">
                    <i class="bi bi-shield-lock"></i> Logs de Acesso
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.settings.index') }}">
                    <i class="bi bi-gear"></i> Configurações
                </a>
            </li>
        </ul>
    </nav>
</div>