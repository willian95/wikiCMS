// Menú responsive
$(function () {
  $('[data-toggle="offcanvas"]').on("click", function () {
    $(".offcanvas-collapse").toggleClass("open");
    $("body").toggleClasss("offcanvas-expanded");
  });


  $(".hamburger").on("click", function () {
    $(this).toggleClass("is-active");
  });

  $(".nav-link").click(function () {
    $(".offcanvas-collapse").removeClass("open");
    $(".hamburger").toggleClass("is-active");
    $("body").removeClass("offcanvas-expanded");
  });






});

$(function () {

  $('.drop-box').click(function () {
    $('#ul')
      .fadeToggle();
  });

  $('.drop-box').on('click', function () {
    $(this).toggleClass('marked');
    $('.drop-text').toggleClass('marked1');
  });

  $(".drop-box").click(function () {
    $('.rotate').toggleClass("down");
  });



  $('.dropdown-toggle').dropdown()
 // Fix input element click problem
 $('.dropdown input, .dropdown label').click(function(e) {
  e.stopPropagation();
});
  $('.collapse').collapse()

});




$(window).scroll(function() {

  var st = $(this).scrollTop();

  if (st > 500) {
    $('.up').addClass('up-show');

  } else {
    $('.up').removeClass('up-show');
  }

}) 