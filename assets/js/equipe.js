document.addEventListener("DOMContentLoaded", function () {
    new Swiper(".benevoles-slider", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true, // Active la boucle infinie
        autoplay: {
            delay: 3000, // Slide automatique toutes les 3 secondes
            disableOnInteraction: false, // Continue même après interaction
        },
        navigation: {
            nextEl: ".benevoles-slider .swiper-button-next",
            prevEl: ".benevoles-slider .swiper-button-prev",
        },
        pagination: {
            el: ".benevoles-slider .swiper-pagination",
            clickable: true,
        },
    });

    new Swiper(".salaries-slider", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true, // Active la boucle infinie
        autoplay: {
            delay: 3000, // Slide automatique toutes les 3 secondes
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".salaries-slider .swiper-button-next",
            prevEl: ".salaries-slider .swiper-button-prev",
        },
        pagination: {
            el: ".salaries-slider .swiper-pagination",
            clickable: true,
        },
    });
});
