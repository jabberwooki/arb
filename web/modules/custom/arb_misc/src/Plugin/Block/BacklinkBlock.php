<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 01/02/19
 * Time: 16:46
 */

/**
 * @file
 * Contains \Drupal\arb_misc\Plugin\Block\BacklinkBlock.
 */

namespace Drupal\arb_misc\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * @Block(
 *   id = "backlink_block",
 *   admin_label = "Lien retour",
 *   category = @Translation("Custom")
 * )
 */
class BacklinkBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $backlink = NULL;
    $referer = $_SERVER['HTTP_REFERER'];
    $tab = \Drupal::request()->query->get('tab');

    // Si l'url referer n'est pas d'un autre site, alors on l'utilise comme backlink
    if (parse_url($referer)['host'] == \Drupal::request()->getHost()) {
      $backlink = $referer;

      if ($tab) {
        $backlink .= '#' . $tab;
      }
    }

    return [
      '#theme' => 'backlink__block',
      '#backlink' => $backlink,
      '#cache' => ['max-age' => 0],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }
}
