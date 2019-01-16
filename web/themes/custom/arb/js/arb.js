(function ($) {
  Drupal.behaviors.news = {
    attach: function (context, settings) {
      // Diaporama
      $('#block-views-block-slides-frontpage-slideshow .view-content').slick({
        dots: true,
        speed: 1500,
        autoplay: true,
        arrows: false,
        fade: true
      });

      // Slick carousel les essentiels (Actus)
      $('#block-views-block-news-block .view-content').slick({
        arrows: true,
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                arrows: true
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2
              }
            },
            {
              breakpoint: 480,
              settings: {
                dots:true,
                arrows: false,
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
          ]
      });
    }
  };
})(jQuery);