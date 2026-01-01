// Service Details Toggle
document.querySelectorAll('.service-item').forEach(item => {
    item.addEventListener('click', function() {
        const serviceType = this.getAttribute('data-service');
        const detailsSection = document.getElementById(`${serviceType}-details`);
        
        // Close any open details first
        document.querySelectorAll('.service-details').forEach(detail => {
            detail.classList.remove('active');
        });
        
        // Show selected details
        if (detailsSection) {
            detailsSection.classList.add('active');
            //document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }
    });
});

// Close Details
document.querySelectorAll('.close-details').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.service-details').forEach(detail => {
            detail.classList.remove('active');
        });
        document.body.style.overflow = ''; // Restore scrolling
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
            detail.classList.remove('active');
        });
        document.body.style.overflow = '';
    }
});

// Mobile Menu Toggle
const menuToggle = document.querySelector('.menu-toggle');
const navMenu = document.querySelector('.nav-menu');

menuToggle.addEventListener('click', () => {
    navMenu.classList.toggle('active');
    
    // Animate hamburger menu
    const spans = menuToggle.querySelectorAll('span');
    if (navMenu.classList.contains('active')) {
        spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
        spans[1].style.opacity = '0';
        spans[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
    } else {
        spans[0].style.transform = 'none';
        spans[1].style.opacity = '1';
        spans[2].style.transform = 'none';
    }
});

// Close mobile menu when clicking on a link
document.querySelectorAll('.nav-menu a').forEach(link => {
    link.addEventListener('click', () => {
        navMenu.classList.remove('active');
        const spans = menuToggle.querySelectorAll('span');
        spans[0].style.transform = 'none';
        spans[1].style.opacity = '1';
        spans[2].style.transform = 'none';
    });
});

// Smooth scroll for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
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

// Navbar background on scroll
const navbar = document.querySelector('.navbar');
let lastScroll = 0;

window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;
    
    if (currentScroll > 100) {
        navbar.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
    } else {
        navbar.style.boxShadow = '0 1px 2px 0 rgba(0, 0, 0, 0.05)';
    }
    
    lastScroll = currentScroll;
});

// Intersection Observer for fade-in animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe elements for animation
document.addEventListener('DOMContentLoaded', () => {
    const animateElements = document.querySelectorAll('.service-card, .portfolio-item, .stat-item, .contact-item');
    
    animateElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(el);
    });
});

/* // Form submission handler
const contactForm = document.getElementById('contactForm');

contactForm.addEventListener('submit', (e) => {
    e.preventDefault();
    
    // Get form values
    const formData = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        subject: document.getElementById('subject').value,
        message: document.getElementById('message').value
    };
    
    // Here you would typically send the data to a server
    console.log('Form submitted:', formData);
    
    // Show success message
    alert('Thank you for your message! We will get back to you soon.');
    
    // Reset form
    contactForm.reset();
}); */

// Add active state to navigation links based on scroll position
const sections = document.querySelectorAll('section[id]');

window.addEventListener('scroll', () => {
    const scrollY = window.pageYOffset;
    
    sections.forEach(section => {
        const sectionHeight = section.offsetHeight;
        const sectionTop = section.offsetTop - 100;
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
});

// Add parallax effect to hero section (disabled to prevent overlap issues)
// window.addEventListener('scroll', () => {
//     const scrolled = window.pageYOffset;
//     const hero = document.querySelector('.hero');
//     if (hero && scrolled < window.innerHeight) {
//         hero.style.transform = `translateY(${scrolled * 0.5}px)`;
//     }
// });

// Performance optimization: Debounce scroll events
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

// Apply debounce to scroll handlers
const debouncedScroll = debounce(() => {
    // Scroll-based animations can be added here
}, 10);

window.addEventListener('scroll', debouncedScroll);

// Testimonial slider logic (run immediately for compatibility with scripts at end of body)
(function() {
    const slider = document.querySelector('.testimonial-slider');
    const items = document.querySelectorAll('.testimonial-slider .testimonial-item');
    const prevBtn = document.querySelector('.testimonial-slider-btn-prev');
    const nextBtn = document.querySelector('.testimonial-slider-btn-next');
    if (!slider || !prevBtn || !nextBtn || !items.length) return;

    function getItemWidth() {
        if (!items[0]) return 0;
        const style = window.getComputedStyle(items[0]);
        return items[0].offsetWidth + parseInt(style.marginRight);
    }
    function updateButtons() {
        if (!slider) return;
        const maxScroll = slider.scrollWidth - slider.clientWidth - 2;
        prevBtn.disabled = slider.scrollLeft <= 2;
        nextBtn.disabled = slider.scrollLeft >= maxScroll;
    }
    function slide(dir) {
        const itemWidth = getItemWidth();
        slider.scrollBy({ left: dir * itemWidth, behavior: 'smooth' });
        setTimeout(updateButtons, 400);
    }
    prevBtn.addEventListener('click', function() { slide(-1); });
    nextBtn.addEventListener('click', function() { slide(1); });
    slider.addEventListener('scroll', updateButtons);
    window.addEventListener('resize', updateButtons);
    setTimeout(updateButtons, 600);
})();

