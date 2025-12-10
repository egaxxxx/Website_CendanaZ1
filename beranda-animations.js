/**
 * BERANDA DYNAMIC ANIMATIONS
 * JavaScript untuk animasi interaktif halaman beranda
 */

// ============================================
// 1. SCROLL ANIMATIONS (Intersection Observer)
// ============================================

document.addEventListener('DOMContentLoaded', function () {

    // Observe all animated elements
    const observerOptions = {
        threshold: 0.15,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');

                // Stat cards just fade in, no counter animation needed
                // Values are already set from PHP
            }
        });
    }, observerOptions);

    // Observe all elements with animation classes
    const animatedElements = document.querySelectorAll('.fade-in-up, .fade-in, .slide-in-left, .slide-in-right, .stat-card');
    animatedElements.forEach(el => observer.observe(el));


    // ============================================
    // 2. COUNTER ANIMATIONS (Hero Stats)
    // ============================================

    function animateCounter(element) {
        const target = parseFloat(element.getAttribute('data-target'));
        const isDecimal = target % 1 !== 0;
        const duration = 2000; // 2 seconds
        const steps = 60;
        const increment = target / steps;
        const stepDuration = duration / steps;

        let current = 0;
        element.classList.add('counted');

        const timer = setInterval(() => {
            current += increment;

            if (current >= target) {
                element.textContent = isDecimal ? target.toFixed(1) : Math.floor(target) + '+';
                clearInterval(timer);
            } else {
                element.textContent = isDecimal ? current.toFixed(1) : Math.floor(current);
            }
        }, stepDuration);
    }


    // ============================================
    // 3. TESTIMONIAL CAROUSEL - 3 CARDS + 1 HALF
    // ============================================

    const testimonialTrack = document.getElementById('testimonialTrack');
    const carouselDots = document.querySelectorAll('.carousel-dot');
    const testimonialSlides = document.querySelectorAll('.testimonial-slide');

    if (testimonialTrack && carouselDots.length > 0 && testimonialSlides.length > 0) {
        let currentIndex = 0;
        const totalSlides = testimonialSlides.length;
        let autoPlayInterval;
        let isTransitioning = false;
        const gap = 24; // gap antar card

        function calculateOffset() {
            // Hitung offset berdasarkan offsetWidth card pertama + gap
            const firstCard = testimonialSlides[0];
            const cardWidth = firstCard.offsetWidth;
            const slideStep = cardWidth + gap;
            return currentIndex * slideStep;
        }

        function goToSlide(slideIndex) {
            if (isTransitioning) return;
            
            isTransitioning = true;
            currentIndex = slideIndex;
            
            // Calculate pixel-based offset
            const offset = calculateOffset();
            testimonialTrack.style.transform = `translateX(-${offset}px)`;

            // Update dots
            carouselDots.forEach((dot, index) => {
                if (index === currentIndex) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });

            // Reset transition lock after animation completes
            setTimeout(() => {
                isTransitioning = false;
            }, 600);
        }

        function nextSlide() {
            const next = (currentIndex + 1) % totalSlides;
            goToSlide(next);
        }

        function prevSlide() {
            const prev = (currentIndex - 1 + totalSlides) % totalSlides;
            goToSlide(prev);
        }

        function startAutoPlay() {
            stopAutoPlay();
            autoPlayInterval = setInterval(nextSlide, 6000); // 6 seconds
        }

        function stopAutoPlay() {
            if (autoPlayInterval) {
                clearInterval(autoPlayInterval);
                autoPlayInterval = null;
            }
        }

        // Dot navigation
        carouselDots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                stopAutoPlay();
                goToSlide(index);
                startAutoPlay();
            });
        });

        // Pause on hover
        const testimonialCarousel = document.querySelector('.testimonial-carousel');
        if (testimonialCarousel) {
            testimonialCarousel.addEventListener('mouseenter', stopAutoPlay);
            testimonialCarousel.addEventListener('mouseleave', startAutoPlay);
        }

        // Touch/swipe support for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        testimonialTrack.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
            stopAutoPlay();
        }, { passive: true });

        testimonialTrack.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
            startAutoPlay();
        }, { passive: true });

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
        }

        // Recalculate on window resize
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                goToSlide(currentIndex);
            }, 250);
        });

        // Initialize
        goToSlide(0);
        startAutoPlay();
    }


    // ============================================
    // 4. PARALLAX EFFECT (Hero Background)
    // ============================================

    const heroSection = document.querySelector('.hero-dynamic');

    if (heroSection) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const heroHeight = heroSection.offsetHeight;

            if (scrolled < heroHeight) {
                const floatCircle = heroSection.querySelector('.float-circle');
                const floatSquare = heroSection.querySelector('.float-square');

                if (floatCircle) {
                    floatCircle.style.transform = `translateY(${scrolled * 0.3}px)`;
                }
                if (floatSquare) {
                    floatSquare.style.transform = `translateY(${scrolled * 0.2}px) rotate(45deg)`;
                }
            }
        });
    }


    // ============================================
    // 5. SMOOTH SCROLL FOR HORIZONTAL CONTAINER
    // ============================================

    const horizontalScrollContainer = document.querySelector('.horizontal-scroll-container');

    if (horizontalScrollContainer) {
        let isDown = false;
        let startX;
        let scrollLeft;

        horizontalScrollContainer.addEventListener('mousedown', (e) => {
            isDown = true;
            horizontalScrollContainer.style.cursor = 'grabbing';
            startX = e.pageX - horizontalScrollContainer.offsetLeft;
            scrollLeft = horizontalScrollContainer.scrollLeft;
        });

        horizontalScrollContainer.addEventListener('mouseleave', () => {
            isDown = false;
            horizontalScrollContainer.style.cursor = 'grab';
        });

        horizontalScrollContainer.addEventListener('mouseup', () => {
            isDown = false;
            horizontalScrollContainer.style.cursor = 'grab';
        });

        horizontalScrollContainer.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - horizontalScrollContainer.offsetLeft;
            const walk = (x - startX) * 2; // Scroll speed
            horizontalScrollContainer.scrollLeft = scrollLeft - walk;
        });

        // Set initial cursor
        horizontalScrollContainer.style.cursor = 'grab';
    }


    // ============================================
    // 6. MASONRY GRID HEIGHT ADJUSTMENT
    // ============================================

    const masonryGrid = document.querySelector('.masonry-grid');

    if (masonryGrid) {
        // Wait for images to load before adjusting grid
        const masonryImages = masonryGrid.querySelectorAll('img');

        Promise.all(Array.from(masonryImages).map(img => {
            if (img.complete) {
                return Promise.resolve();
            }
            return new Promise(resolve => {
                img.addEventListener('load', resolve);
                img.addEventListener('error', resolve);
            });
        })).then(() => {
            // Grid is now properly laid out
            console.log('Masonry grid images loaded');
        });
    }


    // ============================================
    // 7. ADD HOVER SOUND EFFECT (Optional)
    // ============================================

    // Subtle hover feedback for cards
    const interactiveCards = document.querySelectorAll(
        '.service-card-featured, .service-card-small, ' +
        '.benefit-item, .payment-card-scroll, ' +
        '.testimonial-slide, .timeline-step, ' +
        '.masonry-item, .legality-item'
    );

    interactiveCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            // Optional: Add subtle scale or shadow effect
            // Already handled by CSS
        });
    });


    // ============================================
    // 8. LAZY LOADING FOR IMAGES (Performance)
    // ============================================

    if ('IntersectionObserver' in window) {
        const lazyImages = document.querySelectorAll('img[data-src]');

        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    imageObserver.unobserve(img);
                }
            });
        });

        lazyImages.forEach(img => imageObserver.observe(img));
    }


    // ============================================
    // 9. VIEWPORT HEIGHT FIX FOR MOBILE
    // ============================================

    function setViewportHeight() {
        const vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
    }

    setViewportHeight();
    window.addEventListener('resize', setViewportHeight);


    // ============================================
    // 10. PRELOAD CRITICAL IMAGES
    // ============================================

    const criticalImages = [
        'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=800',
        'https://images.unsplash.com/photo-1488646953014-85cb44e25828',
        'https://images.unsplash.com/photo-1506905925346-21bda4d32df4',
        'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800'
    ];

    criticalImages.forEach(src => {
        const link = document.createElement('link');
        link.rel = 'preload';
        link.as = 'image';
        link.href = src;
        document.head.appendChild(link);
    });


    console.log('✨ Beranda Dynamic Animations initialized successfully!');
});


// ============================================
// END OF BERANDA ANIMATIONS
// ============================================
