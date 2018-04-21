// Кнопка на мобильном
$('#touch-menu').click(function(e) {
    e.preventDefault();
    $('.menu').slideToggle();
});

// Скрыть при клике на мобильном
$('.menu a').click(function(e) {
    $('.menu').removeAttr('style');
});

// Resize
function menu_resize(){
    $('#menu-back').outerHeight($('#menu-holder').outerHeight());
    if($(window).width() > 760) {
        $('.menu').removeAttr('style');
    }
}
menu_resize();
$(window).resize(menu_resize);