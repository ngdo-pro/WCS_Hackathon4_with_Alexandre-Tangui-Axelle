$(document).ready(function(){
    $('#scrollToSection1').on('click', function(){
        $('html, body').animate({scrollTop: $('#section1').offset().top}, 450);
    });
});