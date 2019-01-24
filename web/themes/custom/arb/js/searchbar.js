/**
 * Created by ubuntu on 02/10/18.
 */

(function ($) {
  Drupal.behaviors.searchBar = {
    attach: function (context, settings) {
      $('.region-highlighted .search-block-form').hide();

      $('span.fa-search').on('click', function(event){
        $('.region-highlighted .search-block-form').slideToggle();
        event.stopImmediatePropagation();
        $('.region-highlighted input[type="search"]').focus();
      });

      $('#searchformclose').on('click', function(event){
        $('.region-highlighted .search-block-form').slideToggle();
        event.stopImmediatePropagation();
      });
    }
  };
})(jQuery);
