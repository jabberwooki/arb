<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 16/01/19
 * Time: 17:09
 */

/**
 * @file
 * Contains \Drupal\arb_regions\Plugin\Block\RegionOperationsBlock.
 */

namespace Drupal\arb_regions\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\group\Entity\Group;
use Drupal\user\Entity\User;

/**
 * @Block(
 *   id = "regions_operations_block",
 *   admin_label = "Création de contenu dans une région",
 *   category = @Translation("Custom")
 * )
 */
class RegionOperationsBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $items = [];


    $current_user = User::load(\Drupal::currentUser()->id());
    $current_user_region = $current_user->get('field_region')->getValue();

    if (sizeof($current_user_region) != 0) {
      //$contents = ['news' => 'actualité', 'slide' => 'diapositive', 'document' => 'Document'];
      $contents = [
        'news' => [
          'title' =>'actualité',
          'class' => 'news',
        ],
        'slide' => [
          'title' =>'diapositive',
          'class' => 'slides',
        ],
        'document' => [
          'title' => 'Document',
          'class' => 'documents',
        ]
      ];
      $current_user_region_id = reset($current_user_region)['target_id'];

      foreach ($contents as $key=>$data) {
        $items[$key] = [
          'title' => 'Créer une ' . $data['title'],
          'url' => $_SERVER['HTTP_HOST'] . '/group/' . $current_user_region_id .'/content/create/group_node:' . $key,
          'class' => $data['class']
        ];
      }
    }

    return [
      '#theme' => 'region_operations__block',
      '#items' => $items,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }
}