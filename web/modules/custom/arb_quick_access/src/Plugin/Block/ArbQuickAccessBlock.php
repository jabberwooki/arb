<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 19/12/18
 * Time: 08:00
 */

/**
 * @file
 * Contains \Drupal\arb_quick_access\Plugin\Block\ArbQuickAccessBlock.
 */

namespace Drupal\arb_quick_access\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * @Block(
 *   id = "arb_quick_access_block",
 *   admin_label = @Translation("ARB Quick Access Block"),
 *   category = @Translation("Custom")
 * )
 */
class ArbQuickAccessBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $agenda_text = 'Voir l\'agenda';
    $agenda_link = '/agenda/' . date('Ym') . '/';
    $thematics_text = 'Nos thématiques';
    $thematics_link = '/thematiques';

    return [
      '#theme' => 'arb_quick_access__block',
      '#agenda_text' => $agenda_text,
      '#agenda_link' => $agenda_link,
      '#thematics_text' => $thematics_text,
      '#thematics_link' => $thematics_link,
    ];
  }
}
