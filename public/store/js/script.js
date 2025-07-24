document.addEventListener('DOMContentLoaded', () => {
    // --- NAVEGAÇÃO MOBILE (SLIDE-IN) ---
    const menuToggle = document.getElementById('mobile-menu-toggle');
    const navContainer = document.getElementById('nav-container');
    if (menuToggle && navContainer) {
        const menuIcon = menuToggle.querySelector('i');
        menuToggle.addEventListener('click', () => {
            const isOpen = navContainer.classList.toggle('open');
            document.body.classList.toggle('menu-open', isOpen);
            menuIcon.className = isOpen ? 'fas fa-times' : 'fas fa-bars';
            menuToggle.setAttribute('aria-expanded', isOpen);
        });
    }
    
    // --- LÓGICA DO CARROSSEL HERO ---
    const track = document.querySelector('.carousel-track');
    if (track && window.innerWidth > 768) { // Roda o carrossel apenas em telas maiores
        const slides = Array.from(track.children);
        const nextButton = document.querySelector('.carousel-button--right');
        const prevButton = document.querySelector('.carousel-button--left');
        const dotsNav = document.querySelector('.carousel-nav');
        
        slides.forEach((slide, index) => {
            const dot = document.createElement('button');
            dot.classList.add('carousel-indicator');
            if (index === 0) dot.classList.add('current-slide');
            dotsNav.appendChild(dot);
        });

        const dots = Array.from(dotsNav.children);

        const moveToSlide = (currentSlide, targetSlide) => {
            currentSlide.classList.remove('current-slide');
            targetSlide.classList.add('current-slide');
        };

        const updateDots = (currentDot, targetDot) => {
            currentDot.classList.remove('current-slide');
            targetDot.classList.add('current-slide');
        };

        const getNextSlide = () => {
            const currentSlide = track.querySelector('.current-slide');
            let nextSlide = currentSlide.nextElementSibling;
            if (!nextSlide) {
                nextSlide = slides[0];
            }
            return nextSlide;
        }

        let slideInterval = setInterval(() => {
            const currentSlide = track.querySelector('.current-slide');
            const nextSlide = getNextSlide();
            moveToSlide(currentSlide, nextSlide);

            const currentDot = dotsNav.querySelector('.current-slide');
            const nextDotIndex = dots.indexOf(currentDot) + 1;
            const nextDot = dots[nextDotIndex] || dots[0];
            updateDots(currentDot, nextDot);
        }, 5000);

        const resetInterval = () => {
            clearInterval(slideInterval);
            slideInterval = setInterval(() => {
                const currentSlide = track.querySelector('.current-slide');
                const nextSlide = getNextSlide();
                moveToSlide(currentSlide, nextSlide);

                const currentDot = dotsNav.querySelector('.current-slide');
                const nextDotIndex = dots.indexOf(currentDot) + 1;
                const nextDot = dots[nextDotIndex] || dots[0];
                updateDots(currentDot, nextDot);
            }, 5000);
        }

        nextButton.addEventListener('click', e => {
            const currentSlide = track.querySelector('.current-slide');
            const nextSlide = getNextSlide();
            moveToSlide(currentSlide, nextSlide);

            const currentDot = dotsNav.querySelector('.current-slide');
            const nextDot = dots[slides.indexOf(nextSlide)];
            updateDots(currentDot, nextDot);
            resetInterval();
        });

        prevButton.addEventListener('click', e => {
            const currentSlide = track.querySelector('.current-slide');
            const prevSlide = slides[(slides.indexOf(currentSlide) - 1 + slides.length) % slides.length];
            moveToSlide(currentSlide, prevSlide);
            
            const currentDot = dotsNav.querySelector('.current-slide');
            const prevDot = dots[slides.indexOf(prevSlide)];
            updateDots(currentDot, prevDot);
            resetInterval();
        });

        dotsNav.addEventListener('click', e => {
            const targetDot = e.target.closest('button.carousel-indicator');
            if (!targetDot) return;
            
            const currentSlide = track.querySelector('.current-slide');
            const currentDot = dotsNav.querySelector('.current-slide');
            const targetIndex = dots.findIndex(dot => dot === targetDot);
            const targetSlide = slides[targetIndex];

            moveToSlide(currentSlide, targetSlide);
            updateDots(currentDot, targetDot);
            resetInterval();
        });
    }
    
    // --- EFEITO TYPING NO HERO ---
    const heroTitle = document.getElementById('hero-title');
    if (heroTitle) {
        const messages = [
            "Licenças autênticas.",
            "Preços imbatíveis.",
            "Entrega Imediata.",
            "Sua Aventura Começa Aqui."
        ];
        let messageIndex = 0;
        let charIndex = 0;
        let isDeleting = false;
        
        const typeSpeed = 100;
        const deleteSpeed = 50;
        const delayBetweenMessages = 2000;

        const typeEffect = () => {
            const currentMessage = messages[messageIndex];
            
            if (isDeleting) {
                heroTitle.innerHTML = currentMessage.substring(0, charIndex - 1) + '<span class="cursor">&nbsp;</span>';
                charIndex--;
                
                if (charIndex === 0) {
                    isDeleting = false;
                    messageIndex = (messageIndex + 1) % messages.length;
                    setTimeout(typeEffect, 500);
                } else {
                    setTimeout(typeEffect, deleteSpeed);
                }
            } else {
                heroTitle.innerHTML = currentMessage.substring(0, charIndex + 1) + '<span class="cursor">&nbsp;</span>';
                charIndex++;
                
                if (charIndex === currentMessage.length) {
                    isDeleting = true;
                    setTimeout(typeEffect, delayBetweenMessages);
                } else {
                    setTimeout(typeEffect, typeSpeed);
                }
            }
        };
        
        typeEffect();
    }
    
    // --- EFEITO 3D UNIFICADO (TOQUE + MOUSE) ---
    document.querySelectorAll('.product-card').forEach(card => {
        const cardInner = card.querySelector('.product-card-inner');
        let animationFrameId = null;

        const applyTilt = (x, y) => {
            const { left, top, width, height } = card.getBoundingClientRect();
            const relX = x - left;
            const relY = y - top;
            const rotateY = 12 * ((relX - width / 2) / width);
            const rotateX = -12 * ((relY - height / 2) / height);
            
            cardInner.style.transition = 'transform 0.1s ease-out';
            cardInner.style.transform = `scale(1.05) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        };

        card.addEventListener('mouseenter', e => { cardInner.classList.add('is-interactive'); });
        card.addEventListener('mousemove', e => { cancelAnimationFrame(animationFrameId); animationFrameId = requestAnimationFrame(() => applyTilt(e.clientX, e.clientY)); });
        card.addEventListener('mouseleave', () => { cancelAnimationFrame(animationFrameId); cardInner.classList.remove('is-interactive'); cardInner.style.transition = 'transform 0.6s cubic-bezier(0.23, 1, 0.32, 1)'; cardInner.style.transform = 'scale(1) rotateX(0) rotateY(0)'; });
        card.addEventListener('touchstart', e => { cardInner.classList.add('is-interactive'); const touch = e.touches[0]; applyTilt(touch.clientX, touch.clientY); }, { passive: true });
        card.addEventListener('touchmove', e => { cancelAnimationFrame(animationFrameId); e.preventDefault(); const touch = e.touches[0]; animationFrameId = requestAnimationFrame(() => applyTilt(touch.clientX, touch.clientY)); }, { passive: false });
        card.addEventListener('touchend', () => { cancelAnimationFrame(animationFrameId); cardInner.classList.remove('is-interactive'); cardInner.style.transition = 'transform 0.6s cubic-bezier(0.23, 1, 0.32, 1)'; cardInner.style.transform = 'scale(1) rotateX(0) rotateY(0)'; });
    });

    // --- LÓGICA DO BOTÃO DE FAVORITO ---
    document.querySelectorAll('.favorite-btn').forEach(button => {
        button.addEventListener('click', (e) => {
            e.stopPropagation();
            const isFavorited = button.classList.toggle('favorited');
            const icon = button.querySelector('i');
            if (isFavorited) { icon.classList.remove('far'); icon.classList.add('fas'); button.setAttribute('aria-label', 'Remover dos Favoritos'); } else { icon.classList.remove('fas'); icon.classList.add('far'); button.setAttribute('aria-label', 'Adicionar aos Favoritos'); }
        });
    });

    // --- ANIMAÇÃO DE SCROLL (REVEAL) ---
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    
    // --- FAQ ACCORDION ---
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', () => {
            const item = question.parentElement;
            const wasActive = item.classList.contains('active');
            document.querySelectorAll('.faq-item.active').forEach(activeItem => { activeItem.classList.remove('active'); });
            if (!wasActive) { item.classList.add('active'); }
        });
    });
});

// DGS (DRAG 2 SCROLL CATEGORIAS)

document.querySelectorAll('.horizontal-scroll-wrapper').forEach(container => {
    let isDragging = false;
    let startX = 0;
    let scrollStart = 0;

    const setDraggingCursor = (dragging) => {
        container.style.cursor = dragging ? 'grabbing' : 'grab';
    };

    const startDrag = (x) => {
        isDragging = true;
        startX = x;
        scrollStart = container.scrollLeft;
        setDraggingCursor(true);
    };

    const endDrag = () => {
        isDragging = false;
        setDraggingCursor(false);
    };

    const handleMove = (x) => {
        if (!isDragging) return;
        const distance = (x - startX) * 2;
        container.scrollLeft = scrollStart - distance;
    };

    container.addEventListener('mousedown', e => startDrag(e.pageX));
    container.addEventListener('mouseup', endDrag);
    container.addEventListener('mouseleave', endDrag);
    container.addEventListener('mousemove', e => {
        e.preventDefault();
        handleMove(e.pageX);
    });

    container.addEventListener('touchstart', e => {
        if (e.touches.length === 1) startDrag(e.touches[0].pageX);
    }, { passive: true });

    container.addEventListener('touchend', endDrag);
    container.addEventListener('touchcancel', endDrag);
    container.addEventListener('touchmove', e => {
        if (!isDragging) return;
        handleMove(e.touches[0].pageX);
    }, { passive: false });

    setDraggingCursor(false);
});
