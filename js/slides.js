var slideIndex = 0;

function showSlides() {
    var i;
    var slides = document.getElementsByClassName("slides");
    var slideLength = slides.length;
    var dots = document.getElementsByClassName("slides-dot");

    for (i = 0; i < slideLength; i++) {
        slides[i].style.display="none";
    }

    if(dots.length!=0) {
        for (var i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" slides-dot-active", "");
        }
    }

    slideIndex++;
    if(slideIndex > slideLength) {
        slideIndex = 1;
    }

    slides[slideIndex-1].style.display = "block";

    if(dots.length!=0) {
        dots[slideIndex-1].className += " slides-dot-active";
    }

    setTimeout(showSlides, 3000);
}

function slideSet(n) {
    slideIndex = n;
}
