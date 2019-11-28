(function ($) {
  Drupal.behaviors.news = {
    attach: function (context, settings) {
      // Diaporama
      $('#block-views-block-slides-frontpage-slideshow .view-content').slick({
        arrows: true,
        speed: 1500,
        autoplay: true,
        fade: true
      });

      // Slick carousel les essentiels (Actus)
      $('#block-views-block-region-news-front-block .view-content').slick({
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
        
      /*Presentation texte regions*/
      if (typeof flag === 'undefined') {
        flag = true;
      }
      if (flag) {
        $('.region-presentation .field--name-field-presentation p').append("<div class='fade'></div>");
        flag = false;
      }

      // Bandeau région
      $('#block-views-block-regions-banner .field--name-field-image').slick({
        arrows: true,
        speed: 1500,
        autoplay: true,
        fade: true
      });
        
    // Bandeau groupe national
      $('#block-views-block-regions-banner-national .field--name-field-image').slick({
        arrows: true,
        speed: 1500,
        autoplay: true,
        fade: true
      });

      // Slick carousel Membres région
      $('.view-region-members').slick({
        arrows: true,
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 1,
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

      // Gestion de retours depuis node actu ou document vers le bon onglet
      if ($('#arb-dashboard').length && $(location).attr('hash')) {
        $($(location).attr('hash')).trigger('click');
      }

      // Agenda - Appel par défaut du mois en cours pour le lien "Agenda" du menu Hamburger.
      if ($('.menu--hamburger .vieweventsevents-list').length) {
        var agendaUrl = $('.menu--hamburger .vieweventsevents-list').attr('href');
        if (agendaUrl == '/agenda') {
          var currentDate = new Date();
          var month = currentDate.getMonth() + 1;
          var year = currentDate.getFullYear();

          if (month < 10) {
            month = '0' + month;
          }
          console.log(month);
          console.log(year);
          $('.menu--hamburger .vieweventsevents-list').attr('href', '/agenda/' + year + month + '/');
        }
      }

      // Insertion d'une légende d'image sur l'image d'un node actualité.
      if ($('article.news.full').length) {
        if ($('article.news.full img').attr('title')) {
          var newsLegend = $('article.news.full img').attr('title');
          $('article.news.full .field--name-field-image .image-caption').remove(); // pour éviter la répétition de la légende
          $('article.news.full .field--name-field-image').append('<div class="image-caption">' + newsLegend + '</div>');
        }
      }
      // Insertion d'une légende sur l'image d'un node page éditoriale.
      if ($('article.editorial-page.full').length) {
        if ($('article.editorial-page.full img').attr('title')) {
          var editorialPageLegend = $('article.editorial-page.full img').attr('title');
          $('article.editorial-page.full .image-caption').remove(); // pour éviter la répétition de la légende
          $('article.editorial-page.full img').after('<div class="image-caption">' + editorialPageLegend + '</div>');
        }
      }

      // Suppression des textes
      // "Aucune actualité n'est classée dans cette thématique."
      // "Aucun document n'est classé dans cette thématique.
      if (window.location.pathname == '/thematiques' || window.location.pathname == '/thematiques/') {
        $('.view-national-news').css('display', 'none');
        $('.view-national-resources').css('display', 'none');
      }

      // Hauteur des colonnes égales dans l'Agenda.
      if ($('.view-display-id-events_list').length) {
        $('.view-display-id-events_list .grid.horizontal .row').each(function () {
          var highestBox = 0;
          $('.col .wrapper-event', this).each(function () {
            if ($(this).height() > highestBox) {
              highestBox = $(this).height();
            }
          });

          var styleAttr = $('.col .wrapper-event').attr('style');
          if (!styleAttr) {
            $('.col .views-field-nothing .wrapper-event', this).height(highestBox);
          }
        });
      }
    }
  };
})(jQuery);