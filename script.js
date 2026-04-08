// ---------- МОБИЛЬНОЕ МЕНЮ ----------
const menuToggle = document.getElementById('menuToggle');
const navLinks = document.getElementById('navLinks');

menuToggle.addEventListener('click', () => {
    navLinks.classList.toggle('active');
});

document.querySelectorAll('.nav-links a').forEach(link => {
    link.addEventListener('click', () => {
        navLinks.classList.remove('active');
    });
});

// ---------- ПЛАВНАЯ ПРОКРУТКА К ЯКОРЯМ ----------
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href.startsWith('#')) {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});

// ---------- КАРУСЕЛЬ "БЛЮДА НЕДЕЛИ" ----------
const carouselSlides = document.getElementById('carouselSlides');
const slides = document.querySelectorAll('.carousel-slide');
const prevBtn = document.getElementById('carouselPrev');
const nextBtn = document.getElementById('carouselNext');
const dotsContainer = document.getElementById('carouselDots');

let currentIndex = 0;
const slideCount = slides.length;
let autoSlideInterval;

function createDots() {
    dotsContainer.innerHTML = '';
    for (let i = 0; i < slideCount; i++) {
        const dot = document.createElement('div');
        dot.classList.add('carousel-dot');
        if (i === currentIndex) dot.classList.add('active');
        dot.addEventListener('click', () => goToSlide(i));
        dotsContainer.appendChild(dot);
    }
}

function updateCarousel() {
    carouselSlides.style.transform = `translateX(-${currentIndex * 100}%)`;
    const dots = document.querySelectorAll('.carousel-dot');
    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentIndex);
    });
}

function goToSlide(index) {
    if (index < 0) index = slideCount - 1;
    if (index >= slideCount) index = 0;
    currentIndex = index;
    updateCarousel();
}

function nextSlide() {
    goToSlide(currentIndex + 1);
}

function prevSlide() {
    goToSlide(currentIndex - 1);
}

function startAutoSlide() {
    stopAutoSlide();
    autoSlideInterval = setInterval(nextSlide, 5000);
}

function stopAutoSlide() {
    clearInterval(autoSlideInterval);
}

if (slides.length > 0) {
    createDots();
    updateCarousel();
    startAutoSlide();

    const carouselContainer = document.querySelector('.carousel-container');
    carouselContainer.addEventListener('mouseenter', stopAutoSlide);
    carouselContainer.addEventListener('mouseleave', startAutoSlide);

    if (prevBtn) prevBtn.addEventListener('click', () => {
        prevSlide();
        stopAutoSlide();
        startAutoSlide();
    });
    
    if (nextBtn) nextBtn.addEventListener('click', () => {
        nextSlide();
        stopAutoSlide();
        startAutoSlide();
    });
}

// ---------- ФОРМА БРОНИРОВАНИЯ (ОТПРАВКА НА СЕРВЕР) ----------
const bookingForm = document.getElementById('bookingForm');
if (bookingForm) {
    bookingForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(bookingForm);

        try {
            const response = await fetch('save_reservation.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                alert('✅ ' + result.message);
                bookingForm.reset();
            } else {
                alert('❌ Ошибка: ' + result.message);
            }
        } catch (error) {
            alert('Ошибка соединения с сервером');
            console.error(error);
        }
    });
}