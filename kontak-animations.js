/**
 * KONTAK PAGE - SCROLL ANIMATIONS
 * File: kontak-animations.js
 * Modern scroll reveal animations for contact page
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('🎬 Kontak page animations initialized');

    // Initialize scroll reveal observer
    initScrollRevealAnimations();
    
    // Initialize form enhancements
    initFormEnhancements();
});

/**
 * Initialize scroll reveal animations
 */
function initScrollRevealAnimations() {
    const observerOptions = {
        root: null,
        rootMargin: '0px 0px -100px 0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                // Unobserve after animation to improve performance
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all elements with animate-on-scroll class
    const animatedElements = document.querySelectorAll('.animate-on-scroll');
    animatedElements.forEach(el => observer.observe(el));
}

/**
 * Initialize form enhancements
 */
function initFormEnhancements() {
    const form = document.getElementById('contactForm');
    if (!form) return;

    // Add floating label effect
    const inputs = form.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        // Add focus/blur effects
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });

        // Check if already has value on load
        if (input.value) {
            input.parentElement.classList.add('focused');
        }
    });

    // Form submit animation
    const submitBtn = form.querySelector('.btn-submit-modern');
    if (submitBtn) {
        form.addEventListener('submit', function(e) {
            // Show loading state
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="icon icon-spinner"></i> Mengirim...';
            submitBtn.disabled = true;

            // Reset after a moment (actual submit will redirect to WhatsApp)
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });
    }
}

// Smooth scroll to sections
function smoothScrollTo(targetId) {
    const target = document.getElementById(targetId);
    if (target) {
        const headerOffset = 80;
        const targetPosition = target.offsetTop - headerOffset;
        
        window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
        });
    }
}

// Export functions for use in HTML
window.smoothScrollTo = smoothScrollTo;
