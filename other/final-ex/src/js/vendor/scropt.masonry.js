
window.onload = function(){
    var counte = document.querySelector('.grid-block');
    
    var msnry = new Masonry(counte, {
        itemSelector: '.grid__item',
        columnWidth: 300
    });
};