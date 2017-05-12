var App = App || {};

App.MasSlider = function (sliderContainer) {

    var sliderIndex = 0;
    var sliders = sliderContainer.getElementsByClassName('slider');
    var prev = sliderContainer.getElementsByClassName('prev')[0];
    var next = sliderContainer.getElementsByClassName('next')[0];

    prev.addEventListener('click', prevSlide);
    next.addEventListener('click', nextSlide);

    renderSlider();

    function prevSlide() {
        if (sliderIndex == 0) {
            sliderIndex = sliders.length;
        }
        sliderIndex--;
        renderSlider();
    }

    function nextSlide() {
        if (sliderIndex == sliders.length - 1) {
            sliderIndex = -1;
        }
        sliderIndex++;
        renderSlider();
    }

    function renderSlider() {
        for (var i = 0; i < sliders.length; i++) {
            sliders[i].style.display = 'none';
        }
        sliders[sliderIndex].style.display = 'block';
    }

};


function loadSliders() {
    var sliderContainer = document.getElementsByClassName("slider-container");

    for (var i = 0; i < sliderContainer.length; i++) {
        new App.MasSlider(sliderContainer[i]);
    }
}
