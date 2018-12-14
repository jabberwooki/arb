/**
 * Created by ubuntu on 04/10/18.
 */

(function ($) {
  Drupal.behaviors.slidingMenu = {
    attach: function (context, settings) {
      $('#sliding-menu').slidingMenu();
    }
  };
})(jQuery);
