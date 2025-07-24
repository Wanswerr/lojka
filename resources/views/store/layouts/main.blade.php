<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SteamKeys Globais')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('store/css/style.css') }}">
    @yield('styles')
</head>
<body>
    <div class="aurora-background"></div>
    <div class="scanline-overlay"></div>

    <header>
        <div class="header-content">
            <div class="logo">
                {{-- Lógica do Logo que já funciona --}}
                @if (!empty($siteLogo))
                    <a href="{{ route('home') }}"><img src="{{ asset('storage/' . $siteLogo) }}" alt="Logo da Loja" style="max-height: 40px;"></a>
                @else
                    <a href="{{ route('home') }}" style="text-decoration: none; color: inherit;">SteamKeys<span>Globais</span></a>
                @endif
            </div>
            <div class="nav-container" id="nav-container">
                <nav>
                    <a href="{{ route('category.show', ['slug' => 'steam-keys']) }}">Categorias</a> {{-- Exemplo de link --}}
                    <a href="#">Blog</a>
                    <a href="#">Avaliações</a>
                </nav>
                <div class="header-actions">
                    <form class="search-form">
                        <input type="text" placeholder="Procurar..." aria-label="Procurar jogo">
                        <button type="submit" aria-label="Pesquisar"><i class="fas fa-search"></i></button>
                    </form>
                    <a href="#" class="btn btn-primary">Entrar</a>
                </div>
            </div>
            <button class="mobile-menu-toggle" id="mobile-menu-toggle" aria-label="Abrir menu" aria-controls="nav-container"><i class="fas fa-bars"></i></button>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="footer-content">
             <div class="footer-column">
                <h3 class="logo" style="font-size: 1.8rem;">SteamKeys<span>Globais</span></h3>
                <p>{{ $footerText ?? 'Sua jornada gamer começa aqui.' }}</p>
                <div class="social-icons">
                    <a href="#" aria-label="Discord"><i class="fab fa-discord"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            <div class="footer-column">
                <h4>Menu</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Início</a></li>
                    <li><a href="#">Produtos</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Contato</h4>
                <ul>
                    <li><a href="#">Comunidade Discord</a></li>
                    <li><a href="mailto:suporte@steamkeysglobais.com">suporte@steamkeysglobais.com</a></li>
                </ul>
            </div>
             <div class="footer-column">
                <h4>Institucional</h4>
                <ul>
                    <li><a href="#">Termos de Uso</a></li>
                    <li><a href="#">Política de Privacidade</a></li>
                    <li><a href="#">Política de Reembolso</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} SteamKeys Globais. Todos os direitos reservados.
        </div>
    </footer>
    
    <script src="{{ asset('store/js/script.js') }}"></script>
    @yield('scripts')
</body>
</html>