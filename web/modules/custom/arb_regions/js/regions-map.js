/**
 * Created by ubuntu on 28/01/19.
 */

(function ($) {
  Drupal.behaviors.regionsMap = {
    attach: function (context, settings) {
      $('[data-toggle="tooltip"]').tooltip();
    }
  };
})(jQuery);