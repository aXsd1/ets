// ============================================
// ETS İNŞAAT - Enhanced JavaScript
// ============================================

// Performance optimization: Debounce and Throttle functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// ============================================
// Navbar Scroll Effects
// ============================================
const navbar = document.querySelector('.navbar');
const menuToggle = document.querySelector('.menu-toggle');
const navMenu = document.querySelector('.nav-menu');
let lastScroll = 0;

const handleNavbarScroll = throttle(() => {
    const currentScroll = window.pageYOffset;
    
    // Add scrolled class for glass effect enhancement
    if (currentScroll > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
    
    // Hide/show navbar on scroll direction
    if (currentScroll > 500) {
        if (currentScroll > lastScroll) {
            navbar.style.transform = 'translateY(-100%)';
        } else {
            navbar.style.transform = 'translateY(0)';
        }
    } else {
        navbar.style.transform = 'translateY(0)';
    }
    
    lastScroll = currentScroll;
}, 100);

window.addEventListener('scroll', handleNavbarScroll);

// ============================================
// Mobile Menu Toggle with Animations
// ============================================
if (menuToggle && navMenu) {
    menuToggle.addEventListener('click', () => {
        navMenu.classList.toggle('active');
        menuToggle.classList.toggle('active');
        
        // Prevent body scroll when menu is open
        if (navMenu.classList.contains('active')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    });
    
    // Close mobile menu when clicking on a link
    document.querySelectorAll('.nav-menu a').forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('active');
            menuToggle.classList.remove('active');
            document.body.style.overflow = '';
        });
    });
    
    // Close menu on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && navMenu.classList.contains('active')) {
            navMenu.classList.remove('active');
            menuToggle.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
}

// ============================================
// Smooth Scroll for Navigation Links
// ============================================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            const offsetTop = target.offsetTop - 80;
            window.scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });
        }
    });
});

// ============================================
// Active Navigation State on Scroll
// ============================================
const sections = document.querySelectorAll('section[id]');

const updateActiveNav = throttle(() => {
    const scrollY = window.pageYOffset;
    
    sections.forEach(section => {
        const sectionHeight = section.offsetHeight;
        const sectionTop = section.offsetTop - 150;
        const sectionId = section.getAttribute('id');
        
        if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
            document.querySelectorAll('.nav-menu a').forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${sectionId}`) {
                    link.classList.add('active');
                }
            });
        }
    });
}, 100);

window.addEventListener('scroll', updateActiveNav);

// ============================================
// Service Details Modal
// ============================================
document.querySelectorAll('.service-item').forEach(item => {
    item.addEventListener('click', function() {
        const serviceType = this.getAttribute('data-service');
        const detailsSection = document.getElementById(`${serviceType}-details`);
        
        // Close any open details first
        document.querySelectorAll('.service-details').forEach(detail => {
            detail.classList.remove('active');
        });
        
        // Show selected details with body scroll lock
        if (detailsSection) {
            detailsSection.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    });
});

// Close Details
document.querySelectorAll('.close-details').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.service-details').forEach(detail => {
            detail.classList.remove('active');
        });
        document.body.style.overflow = '';
    });
});

// Close details when clicking outside
document.querySelectorAll('.service-details').forEach(detail => {
    detail.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
});

// Close details with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.service-details').forEach(detail => {
            if (detail.classList.contains('active')) {
                detail.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }
});

// ============================================
// Intersection Observer for Scroll Animations
// ============================================
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -80px 0px'
};

const animationObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-in');
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Initialize scroll animations
document.addEventListener('DOMContentLoaded', () => {
    const animateElements = document.querySelectorAll(
        '.service-item, .portfolio-item, .stat-item, .contact-item, .testimonial-item, .section-header, .about-text, .detail-item'
    );
    
    animateElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = `opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1) ${index * 0.05}s, transform 0.6s cubic-bezier(0.16, 1, 0.3, 1) ${index * 0.05}s`;
        animationObserver.observe(el);
    });
});

// ============================================
// Counter Animation for Stats
// ============================================
function animateCounter(element) {
    const target = element.textContent;
    const hasPlus = target.includes('+');
    const hasPercent = target.includes('%');
    const numericValue = parseInt(target.replace(/[^0-9]/g, ''));
    
    if (isNaN(numericValue)) return;
    
    let current = 0;
    const increment = numericValue / 50;
    const duration = 1500;
    const stepTime = duration / 50;
    
    const counter = setInterval(() => {
        current += increment;
        if (current >= numericValue) {
            current = numericValue;
            clearInterval(counter);
        }
        
        let displayValue = Math.floor(current).toLocaleString();
        if (hasPlus) displayValue += '+';
        if (hasPercent) displayValue += '%';
        element.textContent = displayValue;
    }, stepTime);
}

// Observer for stat counters
const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
            entry.target.classList.add('counted');
            animateCounter(entry.target);
        }
    });
}, { threshold: 0.5 });

document.querySelectorAll('.stat-number').forEach(counter => {
    counterObserver.observe(counter);
});

// ============================================
// Testimonial Slider
// ============================================
(function() {
    const slider = document.querySelector('.testimonial-slider');
    const items = document.querySelectorAll('.testimonial-slider .testimonial-item');
    const prevBtn = document.querySelector('.testimonial-slider-btn-prev');
    const nextBtn = document.querySelector('.testimonial-slider-btn-next');
    
    if (!slider || !prevBtn || !nextBtn || !items.length) return;

    let currentIndex = 0;
    let autoSlideInterval;

    function getItemWidth() {
        if (!items[0]) return 0;
        const style = window.getComputedStyle(slider);
        const gap = parseInt(style.gap) || 32;
        return items[0].offsetWidth + gap;
    }

    function updateButtons() {
        if (!slider) return;
        const maxScroll = slider.scrollWidth - slider.clientWidth - 5;
        prevBtn.style.opacity = slider.scrollLeft <= 5 ? '0.5' : '1';
        nextBtn.style.opacity = slider.scrollLeft >= maxScroll ? '0.5' : '1';
        prevBtn.disabled = slider.scrollLeft <= 5;
        nextBtn.disabled = slider.scrollLeft >= maxScroll;
    }

    function slide(dir) {
        const itemWidth = getItemWidth();
        slider.scrollBy({ left: dir * itemWidth, behavior: 'smooth' });
        setTimeout(updateButtons, 400);
    }

    // Auto-slide functionality
    function startAutoSlide() {
        autoSlideInterval = setInterval(() => {
            const maxScroll = slider.scrollWidth - slider.clientWidth;
            if (slider.scrollLeft >= maxScroll - 5) {
                slider.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                slide(1);
            }
        }, 5000);
    }

    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }

    prevBtn.addEventListener('click', () => {
        stopAutoSlide();
        slide(-1);
        startAutoSlide();
    });

    nextBtn.addEventListener('click', () => {
        stopAutoSlide();
        slide(1);
        startAutoSlide();
    });

    slider.addEventListener('scroll', updateButtons);
    slider.addEventListener('mouseenter', stopAutoSlide);
    slider.addEventListener('mouseleave', startAutoSlide);
    
    window.addEventListener('resize', debounce(updateButtons, 100));
    
    setTimeout(() => {
        updateButtons();
        startAutoSlide();
    }, 600);
})();

// ============================================
// Parallax Effect for Hero (Optional - Subtle)
// ============================================
const heroContent = document.querySelector('.hero-content');

if (heroContent) {
    const parallaxScroll = throttle(() => {
        const scrolled = window.pageYOffset;
        const heroHeight = window.innerHeight;
        
        if (scrolled < heroHeight) {
            const opacity = 1 - (scrolled / heroHeight) * 0.5;
            const translateY = scrolled * 0.3;
            heroContent.style.opacity = opacity;
            heroContent.style.transform = `translateY(${translateY}px)`;
        }
    }, 16);

    window.addEventListener('scroll', parallaxScroll);
}

// ============================================
// Cursor Glow Effect (Optional - Desktop Only)
// ============================================
if (window.matchMedia('(hover: hover)').matches && window.innerWidth > 1024) {
    const cursor = document.createElement('div');
    cursor.classList.add('cursor-glow');
    cursor.style.cssText = `
        position: fixed;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(14, 165, 233, 0.08) 0%, transparent 70%);
        pointer-events: none;
        z-index: 9999;
        transform: translate(-50%, -50%);
        transition: opacity 0.3s ease;
        opacity: 0;
    `;
    document.body.appendChild(cursor);

    let cursorVisible = false;
    
    document.addEventListener('mousemove', throttle((e) => {
        cursor.style.left = e.clientX + 'px';
        cursor.style.top = e.clientY + 'px';
        
        if (!cursorVisible) {
            cursor.style.opacity = '1';
            cursorVisible = true;
        }
    }, 16));

    document.addEventListener('mouseleave', () => {
        cursor.style.opacity = '0';
        cursorVisible = false;
    });
}

// ============================================
// Preloader (Optional)
// ============================================
window.addEventListener('load', () => {
    document.body.classList.add('loaded');
    
    // Remove any preloader if exists
    const preloader = document.querySelector('.preloader');
    if (preloader) {
        preloader.style.opacity = '0';
        setTimeout(() => preloader.remove(), 500);
    }
});

// Apply debounce to window resize
window.addEventListener('resize', debounce(() => {
    // Recalculate any dimension-dependent elements
}, 100));

console.log('ETS İnşaat - Modern UI Loaded Successfully ✨');
