<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SteamKeys Globais - Sua Loja de Jogos</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('store/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('store/css/category.css') }}">
</head>
<body>
    <div class="aurora-background"></div>
    <div class="scanline-overlay"></div>

    <header>
        <div class="header-content">
            <div class="logo">
                @if (!empty($siteLogo))
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('storage/' . $siteLogo) }}" alt="Logo da Loja" style="max-height: 40px;">
                    </a>
                @else
                    <a href="{{ route('home') }}" style="text-decoration: none; color: inherit;">
                        SteamKeys<span>Globais</span>
                    </a>
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

            <button class="mobile-menu-toggle" id="mobile-menu-toggle" aria-label="Abrir menu" aria-controls="nav-container">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="hero-carousel" id="hero-carousel">
                <ul class="carousel-track">
                    @foreach($slides as $slide)
                        <li class="carousel-slide @if($loop->first) current-slide @endif" 
                            style="background-image: url('{{ asset('storage/' . $slide->image_path) }}');"
                            data-title="{{ $slide->title }}"
                            data-subtitle="{{ $slide->subtitle }}">
                        </li>
                    @endforeach
                </ul>
                <button class="carousel-button carousel-button--left"><i class="fas fa-chevron-left"></i></button>
                <button class="carousel-button carousel-button--right"><i class="fas fa-chevron-right"></i></button>
                <div class="carousel-nav"></div>
            </div>

            <div class="hero-content">
                <h1 class="reveal" id="hero-title"></h1>
                <p class="reveal" id="hero-subtitle">Onde preço justo encontra qualidade premium. Garanta seus títulos favoritos e jogue com total segurança.</p>
                <div class="hero-buttons reveal">
                    <a href="#produtos" class="btn btn-primary">Ver Produtos</a>
                    <a href="#" class="btn btn-secondary">Junte-se ao Discord</a>
                </div>
            </div>
        </section>

        {{-- SECÇÃO DE CATEGORIAS - COM SCROLL HORIZONTAL --}}
        <div class="container" id="categorias">
            <h2 class="section-title reveal">Nossas Categorias</h2>
            <div class="horizontal-scroll-wrapper">
                <div class="category-grid">
                    @forelse($categories as $category)
                        <a href="{{ route('category.show', ['slug' => $category->slug]) }}" class="info-card-link reveal" style="animation-delay: {{ $loop->iteration * 0.1 }}s;">
                            <div class="info-card" style="background-image: linear-gradient(to top, rgba(30, 25, 43, 0.9), rgba(30, 25, 43, 0.1)), url('{{ $category->image_path ? asset('storage/' . $category->image_path) : 'https://via.placeholder.com/320x200.png?text=Sem+Imagem' }}');">
                                <h3 class="card-name">{{ $category->name }}</h3>
                            </div>
                        </a>
                    @empty
                        <p class="text-center">Nenhuma categoria para exibir no momento.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- SECÇÃO DE PRODUTOS - GRELHA VERTICAL --}}
        @if(isset($categories) && $categories->count() > 0)
            @foreach($categories as $category)
                <div class="container" id="category-{{ $category->slug }}">
                    <h2 class="section-title reveal">{{ $category->name }}</h2>
                    <div class="product-grid">
                        @forelse($category->products as $product)
                            <div class="product-card reveal" style="animation-delay: {{ $loop->iteration * 0.1 }}s;">
                                <div class="product-card-inner">
                                    <div class="product-image-wrapper">
                                        @if($product->image_path)
                                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="Capa do Jogo {{ $product->name }}">
                                        @else
                                            <img src="https://via.placeholder.com/300x400.png?text=Sem+Imagem" alt="Sem Imagem">
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
                                                <button class="action-btn favorite-btn" aria-label="Adicionar aos Favoritos"><i class="far fa-heart"></i></button>
                                                <button class="action-btn add-to-cart-btn" aria-label="Adicionar {{ $product->name }} ao carrinho"><i class="fas fa-cart-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center col-span-full">Nenhum produto encontrado nesta categoria.</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        @endif

        <div class="container" id="faq">
            <h2 class="section-title reveal">Perguntas Frequentes</h2>
            <div class="faq-container reveal">
                <div class="faq-item">
                    <div class="faq-question"><span>Os jogos são originais?</span><i class="fas fa-chevron-down"></i></div>
                    <div class="faq-answer"><p>Sim, todos os jogos são 100% originais, adquiridos de distribuidores oficiais.</p></div>
                </div>
                <div class="faq-item">
                    <div class="faq-question"><span>Como recebo meu jogo?</span><i class="fas fa-chevron-down"></i></div>
                    <div class="faq-answer"><p>Após a confirmação do pagamento, a chave de ativação do seu jogo é enviada instantaneamente para o seu e-mail.</p></div>
                </div>
                <div class="faq-item">
                    <div class="faq-question"><span>E se a chave não funcionar?</span><i class="fas fa-chevron-down"></i></div>
                    <div class="faq-answer"><p>Oferecemos garantia total. Caso encontre qualquer problema com a ativação, nossa equipe de suporte irá ajudá-lo ou providenciar o reembolso completo.</p></div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-column">
                <h3 class="logo" style="font-size: 1.8rem;">SteamKeys<span>Globais</span></h3>
                <p>{{ $footerText ?? 'Sua jornada gamer começa aqui. Explore, compre e jogue com segurança e os melhores preços.' }}</p>
                <div class="social-icons">
                    <a href="#" aria-label="Discord"><i class="fab fa-discord"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                </div>
            </div>

            <div class="footer-column">
                <h4>Menu</h4>
                <ul>
                    <li><a href="#">Início</a></li>
                    <li><a href="#produtos">Produtos</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#">Suporte</a></li>
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
</body>
</html>
