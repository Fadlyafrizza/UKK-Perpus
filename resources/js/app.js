import './bootstrap';

import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const activityCards = document.querySelectorAll('.activity-card');
    const activityGroups = document.querySelectorAll('.activity-group');
    const activityCountElement = document.getElementById('activityCount');

    searchInput.addEventListener('input', function (e) {
        const searchTerm = e.target.value.toLowerCase();
        let visibleCount = 0;

        activityCards.forEach(card => {
            const cardContent = card.textContent.toLowerCase();
            const cardAksi = card.dataset.aksi ? card.dataset.aksi.toLowerCase() : '';
            const shouldShow = cardContent.includes(searchTerm) || cardAksi.includes(searchTerm);

            if (shouldShow) {
                card.style.display = '';
                card.classList.add('fade-in');
                setTimeout(() => card.classList.remove('fade-in'), 200);
                visibleCount++;
            } else {
                card.classList.add('fade-out');
                setTimeout(() => {
                    card.style.display = 'none';
                    card.classList.remove('fade-out');
                }, 200);
            }
        });

        if (activityGroups.length > 0) {
            activityGroups.forEach(group => {
                const groupAksi = group.dataset.aksi ? group.dataset.aksi.toLowerCase() : '';
                const visibleCards = group.querySelectorAll('.activity-card:not([style*="display: none"])');
                if (visibleCards.length > 0 || groupAksi.includes(searchTerm)) {
                    group.style.display = '';
                } else {
                    group.style.display = 'none';
                }
            });
        }

        if (activityCountElement) {
            activityCountElement.textContent = visibleCount;
        }
    });

    searchInput.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            this.value = '';
            this.dispatchEvent(new Event('input'));
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('slider-container');
    const slides = container.children;
    const totalSlides = slides.length;
    const dotsContainer = document.getElementById('pagination-dots');
    let currentSlide = 0;

    for (let i = 0; i < totalSlides; i++) {
        const dot = document.createElement('button');
        dot.className = 'w-2 h-2 rounded-full bg-gray-300';
        dot.setAttribute('type', 'button');
        dot.addEventListener('click', () => goToSlide(i));
        dotsContainer.appendChild(dot);
    }

    function updateDots() {
        const dots = dotsContainer.children;
        for (let i = 0; i < dots.length; i++) {
            dots[i].className = `w-2 h-2 rounded-full ${i === currentSlide ? 'bg-black' : 'bg-gray-300'}`;
        }
    }

    window.moveSlide = function (direction) {
        currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
        updateSlider();
    }

    function goToSlide(index) {
        currentSlide = index;
        updateSlider();
    }

    function updateSlider() {
        const slideWidth = slides[0].offsetWidth;
        container.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
        updateDots();
    }

    document.getElementById('prevButton').addEventListener('click', () => moveSlide(-1));
    document.getElementById('nextButton').addEventListener('click', () => moveSlide(1));

    let touchStartX = 0;
    let touchEndX = 0;

    container.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
    });

    container.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                moveSlide(1);
            } else {
                moveSlide(-1);
            }
        }
    }

    window.addEventListener('resize', updateSlider);

    updateDots();
});

document.addEventListener('DOMContentLoaded', function () {
    const fadlyBawa = document.getElementById('TanggalPeminjaman');
    const fadlyKembali = document.getElementById('TanggalPengembalian');

    fadlyBawa.addEventListener('change', function () {
        const fadlyMinPengembalian = new Date(this.value);
        fadlyMinPengembalian.setDate(fadlyMinPengembalian.getDate() + 1);
        fadlyKembali.min = fadlyMinPengembalian.toISOString().split('T')[0];

        if (fadlyKembali.value && new Date(fadlyKembali.value) <= new Date(this.value)) {
            fadlyKembali.value = fadlyMinPengembalian.toISOString().split('T')[0];
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const starInputs = document.querySelectorAll('.star-input');
    const starSvgs = document.querySelectorAll('.star-svg');

    starInputs.forEach((input, index) => {
        input.addEventListener('change', function () {
            starSvgs.forEach((svg, svgIndex) => {
                if (svgIndex <= index) {
                    svg.classList.remove('text-gray-300');
                    svg.classList.add('text-zinc-700');
                } else {
                    svg.classList.remove('text-zinc-700');
                    svg.classList.add('text-gray-300');
                }
            });
        });
    });
});

