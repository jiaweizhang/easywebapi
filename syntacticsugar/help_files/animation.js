$(document).ready(function () {
    $("#circle-1").css('opacity', 0);
    $(".intro-info-row").css('opacity', 0);
    $('.row-section').css('opacity', 0);

    $("#circle-1").velocity("transition.slideLeftIn", 500);
    $(".intro-info-row").velocity("transition.slideRightIn", 500);
    $('.row-section').delay(150).velocity("transition.slideRightIn", 500);
});