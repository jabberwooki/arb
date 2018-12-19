<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 19/12/18
 * Time: 08:00
 */

/**
 * @file
 * Contains \Drupal\arb_register\Plugin\Block\ArbRegisterBlock.
 */

namespace Drupal\arb_register\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * @Block(
 *   id = "arb_register_block",
 *   admin_label = @Translation("ARB register Block"),
 *   category = @Translation("Custom")
 * )
 */
class ArbRegisterBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
      $register_text = 'Vous souhaitez collaborer avec nous';
      $register_link = 'Inscrivez-vous';

    return [
      '#theme' => 'arb_register__block',
      '#register_text' => $register_text,
      '#register_link' => $register_link
    ];
  }
}
