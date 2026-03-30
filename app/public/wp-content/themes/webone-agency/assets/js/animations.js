/**
 * WebOne Agency - Scroll Animations
 * Handles reveal animations, smooth scrolling, and interactive effects
 */

(function () {
    'use strict';

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function () {
        initScrollReveal();
        initCounterAnimation();
        initSmoothScroll();
        initNavbarScroll();
        initParallax();
        initContactModal();
    });

    /**
     * Scroll Reveal Animation
     * Elements with [data-reveal] attribute will animate when scrolled into view
     */
    function initScrollReveal() {
        const revealElements = document.querySelectorAll('[data-reveal]');

        if (!revealElements.length) return;

        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -100px 0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    // Add staggered delay based on element position
                    const delay = entry.target.dataset.revealDelay || index * 100;

                    setTimeout(() => {
                        entry.target.classList.add('revealed');
                    }, delay);

                    // Unobserve after revealing
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        revealElements.forEach(el => observer.observe(el));
    }

    /**
     * Animated Number Counter
     * Elements with [data-counter] will count up to their value
     */
    function initCounterAnimation() {
        const counters = document.querySelectorAll('[data-counter]');

        if (!counters.length) return;

        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.5
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        counters.forEach(counter => observer.observe(counter));
    }

    /**
     * Animate a single counter element
     */
    function animateCounter(element) {
        const target = parseInt(element.dataset.counter, 10);
        const duration = parseInt(element.dataset.counterDuration, 10) || 2000;
        const suffix = element.dataset.counterSuffix || '';
        const startTime = performance.now();

        function updateCounter(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);

            // Easing function (ease-out-cubic)
            const easeOut = 1 - Math.pow(1 - progress, 3);
            const currentValue = Math.floor(easeOut * target);

            element.textContent = currentValue + suffix;

            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target + suffix;
            }
        }

        requestAnimationFrame(updateCounter);
    }

    /**
     * Smooth Scroll for Anchor Links
     */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const targetId = this.getAttribute('href');

                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    e.preventDefault();

                    const headerOffset = 100;
                    const elementPosition = targetElement.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    /**
     * Navbar Background Change on Scroll
     */
    function initNavbarScroll() {
        const header = document.querySelector('header, .wp-block-template-part');

        if (!header) return;

        let lastScroll = 0;
        const scrollThreshold = 50;

        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;

            if (currentScroll > scrollThreshold) {
                header.classList.add('wa-header-scrolled');
            } else {
                header.classList.remove('wa-header-scrolled');
            }

            // Hide/show header on scroll direction
            if (currentScroll > lastScroll && currentScroll > 200) {
                header.classList.add('wa-header-hidden');
            } else {
                header.classList.remove('wa-header-hidden');
            }

            lastScroll = currentScroll;
        }, { passive: true });
    }

    /**
     * Parallax Effect for Background Elements
     */
    function initParallax() {
        const parallaxElements = document.querySelectorAll('[data-parallax]');

        if (!parallaxElements.length) return;

        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;

            parallaxElements.forEach(el => {
                const speed = parseFloat(el.dataset.parallax) || 0.5;
                const yPos = -(scrolled * speed);
                el.style.transform = `translateY(${yPos}px)`;
            });
        }, { passive: true });
    }

    /**
     * Add hover effects to cards
     */
    function initCardHover() {
        const cards = document.querySelectorAll('.wa-card, .wa-service-card, .wa-project-card, .wa-team-card');

        cards.forEach(card => {
            card.addEventListener('mouseenter', function (e) {
                this.style.transform = 'translateY(-10px)';
            });

            card.addEventListener('mouseleave', function () {
                this.style.transform = 'translateY(0)';
            });
        });
    }

    /**
     * Magnetic Button Effect
     */
    function initMagneticButtons() {
        const buttons = document.querySelectorAll('.wp-block-button__link, .wa-btn');

        buttons.forEach(button => {
            button.addEventListener('mousemove', function (e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;

                this.style.transform = `translate(${x * 0.2}px, ${y * 0.2}px)`;
            });

            button.addEventListener('mouseleave', function () {
                this.style.transform = 'translate(0, 0)';
            });
        });
    }

    /**
     * Text Scramble Effect for headings
     */
    class TextScramble {
        constructor(el) {
            this.el = el;
            this.chars = '!<>-_\\/[]{}—=+*^?#________';
            this.update = this.update.bind(this);
        }

        setText(newText) {
            const oldText = this.el.innerText;
            const length = Math.max(oldText.length, newText.length);
            const promise = new Promise((resolve) => this.resolve = resolve);
            this.queue = [];

            for (let i = 0; i < length; i++) {
                const from = oldText[i] || '';
                const to = newText[i] || '';
                const start = Math.floor(Math.random() * 40);
                const end = start + Math.floor(Math.random() * 40);
                this.queue.push({ from, to, start, end });
            }

            cancelAnimationFrame(this.frameRequest);
            this.frame = 0;
            this.update();
            return promise;
        }

        update() {
            let output = '';
            let complete = 0;

            for (let i = 0, n = this.queue.length; i < n; i++) {
                let { from, to, start, end, char } = this.queue[i];

                if (this.frame >= end) {
                    complete++;
                    output += to;
                } else if (this.frame >= start) {
                    if (!char || Math.random() < 0.28) {
                        char = this.randomChar();
                        this.queue[i].char = char;
                    }
                    output += `<span class="wa-scramble">${char}</span>`;
                } else {
                    output += from;
                }
            }

            this.el.innerHTML = output;

            if (complete === this.queue.length) {
                this.resolve();
            } else {
                this.frameRequest = requestAnimationFrame(this.update);
                this.frame++;
            }
        }

        randomChar() {
            return this.chars[Math.floor(Math.random() * this.chars.length)];
        }
    }

    /**
     * Contact Modal Functionality
     * Creates and manages the contact form modal
     */
    function initContactModal() {
        // Create modal HTML
        const modalHTML = `
            <div class="wa-contact-modal" id="contactModal">
                <div class="wa-modal-backdrop"></div>
                <div class="wa-modal-container">
                    <button class="wa-modal-close" aria-label="Close modal">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                    
                    <div class="wa-modal-header">
                        <div class="wa-modal-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                        <h3 class="wa-modal-title">Let's Build Together</h3>
                        <p class="wa-modal-subtitle">Tell us about your project and we'll get back to you within 24 hours.</p>
                    </div>
                    
                    <form class="wa-modal-form" id="contactForm">
                        <div class="wa-form-row">
                            <div class="wa-form-group">
                                <label class="wa-form-label" for="contactName">Your Name</label>
                                <input type="text" class="wa-form-input" id="contactName" name="name" placeholder="John Doe" required>
                            </div>
                            <div class="wa-form-group">
                                <label class="wa-form-label" for="contactEmail">Email Address</label>
                                <input type="email" class="wa-form-input" id="contactEmail" name="email" placeholder="john@example.com" required>
                            </div>
                        </div>
                        <div class="wa-form-group">
                            <label class="wa-form-label" for="contactSubject">Subject</label>
                            <input type="text" class="wa-form-input" id="contactSubject" name="subject" placeholder="Project Inquiry">
                        </div>
                        <div class="wa-form-group">
                            <label class="wa-form-label" for="contactMessage">Your Message</label>
                            <textarea class="wa-form-textarea" id="contactMessage" name="message" placeholder="Tell us about your project, goals, and timeline..." required></textarea>
                        </div>
                        <button type="submit" class="wa-form-submit">
                            <span class="wa-btn-text">Send Message</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                            </svg>
                        </button>
                    </form>
                    
                    <div class="wa-modal-footer">
                        <p>Or email us directly at <a href="mailto:hello@webone.agency">hello@webone.agency</a></p>
                    </div>
                    
                    <div class="wa-success-overlay" id="successOverlay">
                        <div class="wa-success-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <h3 class="wa-success-title">Message Sent!</h3>
                        <p class="wa-success-message">Thank you for reaching out. We'll get back to you soon.</p>
                    </div>
                </div>
            </div>
        `;

        // Append modal to body
        document.body.insertAdjacentHTML('beforeend', modalHTML);

        const modal = document.getElementById('contactModal');
        const backdrop = modal.querySelector('.wa-modal-backdrop');
        const closeBtn = modal.querySelector('.wa-modal-close');
        const form = document.getElementById('contactForm');
        const successOverlay = document.getElementById('successOverlay');

        // Find all "Get in Touch" buttons and attach click handlers
        const triggerButtons = document.querySelectorAll('.wa-cta .wp-block-button__link, a[href*="mailto:hello@webone.agency"]');

        triggerButtons.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                openModal();
            });
        });

        // Also capture clicks on parent .wa-btn wrapper in CTA
        const ctaBtns = document.querySelectorAll('.wa-cta .wa-btn');
        ctaBtns.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                openModal();
            });
        });

        function openModal() {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';

            // Focus first input after animation
            setTimeout(() => {
                const firstInput = modal.querySelector('.wa-form-input');
                if (firstInput) firstInput.focus();
            }, 500);
        }

        function closeModal() {
            modal.classList.remove('active');
            document.body.style.overflow = '';

            // Reset form and success state after close animation
            setTimeout(() => {
                form.reset();
                successOverlay.classList.remove('active');
                const submitBtn = form.querySelector('.wa-form-submit');
                submitBtn.classList.remove('loading', 'success');
            }, 400);
        }

        // Close on backdrop click
        backdrop.addEventListener('click', closeModal);

        // Close on button click
        closeBtn.addEventListener('click', closeModal);

        // Close on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                closeModal();
            }
        });

        // Form field focus effects
        const formInputs = modal.querySelectorAll('.wa-form-input, .wa-form-textarea');
        formInputs.forEach(input => {
            input.addEventListener('focus', function () {
                this.closest('.wa-form-group').classList.add('focused');
            });
            input.addEventListener('blur', function () {
                this.closest('.wa-form-group').classList.remove('focused');
            });
        });

        // Handle form submission
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const submitBtn = form.querySelector('.wa-form-submit');
            submitBtn.classList.add('loading');

            // Get form data
            const formData = new FormData(form);
            formData.append('action', 'webone_contact_form');
            formData.append('nonce', typeof weboneAjax !== 'undefined' ? weboneAjax.nonce : '');

            // Send AJAX request
            fetch(typeof weboneAjax !== 'undefined' ? weboneAjax.ajaxUrl : '/wp-admin/admin-ajax.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    submitBtn.classList.remove('loading');

                    if (data.success) {
                        submitBtn.classList.add('success');
                        successOverlay.classList.add('active');

                        // Close modal after showing success
                        setTimeout(() => {
                            closeModal();
                        }, 2500);
                    } else {
                        // Show error (you could add an error message UI here)
                        alert(data.data?.message || 'Failed to send message. Please try again.');
                    }
                })
                .catch(error => {
                    submitBtn.classList.remove('loading');
                    alert('An error occurred. Please try again.');
                    console.error('Contact form error:', error);
                });
        });
    }

    // Initialize additional effects after a short delay
    setTimeout(() => {
        initCardHover();
        initMagneticButtons();
    }, 500);

})();
