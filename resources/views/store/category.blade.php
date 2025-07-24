<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }} - SteamKeys Globais</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('store/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('store/css/category-page.css') }}">
</head>
<body>
    <div class="aurora-background"></div>
    <div class="scanline-overlay"></div>

    <header>
        <div class="header-content">
            <div class="logo">
                @if (!empty($siteLogo))
                    <a href="{{ route('home') }}"><img src="{{ asset('storage/' . $siteLogo) }}" alt="Logo da Loja" style="max-height: 40px;"></a>
                @else
                    <a href="{{ route('home') }}" style="text-decoration: none; color: inherit;">SteamKeys<span>Globais</span></a>
                @endif
            </div>
            <div class="nav-container" id="nav-container">
                <nav>
                    <a href="#">Categorias</a>
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
        <div class="container">
            <div class="category-page-layout">
                <aside class="filters-sidebar">
                    <h2>Filtros</h2>
                    {{-- A lógica dos filtros será implementada no futuro --}}
                </aside>

                <section class="product-listing">
                    <div class="listing-header">
                        <div class="listing-title">
                            <h1>{{ $category->name }}</h1>
                            <p>{{ $products->total() }} produtos encontrados</p>
                        </div>
                        <div class="listing-controls">
                            <select class="sort-dropdown">
                                <option>Em destaque</option>
                                <option>Menor Preço</option>
                                <option>Maior Preço</option>
                            </select>
                        </div>
                    </div>

                    <div class="product-grid">
                        @forelse ($products as $product)
                            <div class="product-card">
                                <div class="product-card-inner">
                                    <div class="product-image-wrapper">
                                        @if($product->image_path)
                                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="Capa do Jogo {{ $product->name }}">
                                        @else
                                            <img src="https://via.placeholder.com/300x225/111/fff.png?text=Sem+Imagem" alt="Capa do Jogo">
                                        @endif
                                        <div class="platform-icon"><i class="fas fa-desktop"></i></div>
                                    </div>
                                    <div class="product-info">
                                        <h3 class="product-title">{{ $product->name }}</h3>
                                        <div class="price-section">
                                            <div class="price-wrapper">
                                                <span class="product-price">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                                            </div>
                                            <div class="card-actions">
                                                <button class="action-btn favorite-btn"><i class="far fa-heart"></i></button>
                                                <button class="action-btn add-to-cart-btn" @if($product->available_keys_count == 0) disabled @endif><i class="fas fa-cart-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>Nenhum produto encontrado nesta categoria.</p>
                        @endforelse
                    </div>
                    
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </section>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-column">
                <h3 class="logo" style="font-size: 1.8rem;">SteamKeys<span>Globais</span></h3>
                <p>{{ $footerText ?? 'Sua jornada gamer começa aqui.' }}</p>
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
        <div class="footer-bottom">&copy; {{ date('Y') }} SteamKeys Globais. Todos os direitos reservados.</div>
    </footer>
    
    <script src="{{ asset('store/js/script.js') }}"></script>
</body>
</html>