/* 
   Purfemos Premium Perfume Store
   Interactivity Scripts (v3)
*/

document.addEventListener('DOMContentLoaded', () => {
    console.log('Purfemos v3 script loaded.');

    // Initialize Lucide Icons
    if (window.lucide) {
        window.lucide.createIcons();
    }

    // --- Mobile Menu Toggle ---
    const menuToggle = document.createElement('button');
    menuToggle.className = 'mobile-menu-toggle';
    menuToggle.innerHTML = '<i data-lucide="menu"></i>';
    menuToggle.style.display = 'none'; // Only show on mobile

    const header = document.querySelector('.site-header .container');
    if (header) {
        // header.prepend(menuToggle); // Uncomment when adding mobile styles
    }

    // --- Hero Slider Logic (Basic) ---
    const slides = document.querySelectorAll('.hero-slide');
    let currentSlide = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
            slide.style.opacity = i === index ? '1' : '0';
            slide.style.display = i === index ? 'flex' : 'none';
        });
    }

    // For now, only 1 slide is implemented, so no auto-advance yet.
    // showSlide(currentSlide);

    // --- Popup Logic ---

    // Cookie Consent
    const cookiePopup = document.createElement('div');
    cookiePopup.className = 'popup cookie-popup';
    cookiePopup.innerHTML = `
        <div class="popup-content">
            <p>We use cookies to ensure you get the best experience on our website. <a href="#">Learn more</a></p>
            <button class="btn btn-sm btn-accept-cookies">Accept</button>
        </div>
    `;

    if (!localStorage.getItem('cookies-accepted')) {
        document.body.appendChild(cookiePopup);
        document.querySelector('.btn-accept-cookies').addEventListener('click', () => {
            cookiePopup.style.display = 'none';
            localStorage.setItem('cookies-accepted', 'true');
        });
    }

    // Newsletter Popup (delay 5s)
    setTimeout(() => {
        if (!sessionStorage.getItem('newsletter-closed')) {
            showNewsletterPopup();
        }
    }, 5000);

    function showNewsletterPopup() {
        const newsletterPopup = document.createElement('div');
        newsletterPopup.className = 'popup newsletter-popup-overlay';
        newsletterPopup.innerHTML = `
            <div class="newsletter-popup">
                <button class="popup-close"><i data-lucide="x"></i></button>
                <div class="newsletter-content flex">
                    <div class="newsletter-image">
                        <img src="https://wordpressthemes.live/WCM9/WCM204_purfemos/default/wp-content/uploads/2024/09/popup.jpg" alt="Newsletter">
                    </div>
                    <div class="newsletter-text">
                        <h2>Subscribe Newsletter</h2>
                        <p>Subscribe to our newsletter to receive news and updates on your favorite products.</p>
                        <form class="newsletter-form-popup">
                            <input type="email" placeholder="Email Address" required>
                            <button type="submit" class="btn">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(newsletterPopup);
        window.lucide.createIcons();

        newsletterPopup.querySelector('.popup-close').addEventListener('click', () => {
            newsletterPopup.remove();
            sessionStorage.setItem('newsletter-closed', 'true');
        });
    }

    // Exit Intent Popup
    document.addEventListener('mouseleave', (e) => {
        if (e.clientY < 0 && !sessionStorage.getItem('exit-intent-shown')) {
            showExitIntentPopup();
        }
    });

    function showExitIntentPopup() {
        const exitPopup = document.createElement('div');
        exitPopup.className = 'popup exit-intent-overlay';
        exitPopup.innerHTML = `
            <div class="exit-popup">
                <button class="popup-close"><i data-lucide="x"></i></button>
                <h2>Wait! Don't Miss Out!</h2>
                <p>Get 10% OFF your first order with code: <strong>WELCOME10</strong></p>
                <a href="#" class="btn">Shop Now</a>
            </div>
        `;
        document.body.appendChild(exitPopup);
        window.lucide.createIcons();
        sessionStorage.setItem('exit-intent-shown', 'true');

        exitPopup.querySelector('.popup-close').addEventListener('click', () => {
            exitPopup.remove();
        });
    }
});
