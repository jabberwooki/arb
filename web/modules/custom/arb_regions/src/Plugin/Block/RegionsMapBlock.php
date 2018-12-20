<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 19/12/18
 * Time: 18:15
 */

/**
 * @file
 * Contains \Drupal\arb_regions\Plugin\Block\RegionsMapBlock.
 */

namespace Drupal\arb_regions\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\group\Entity\Group;

/**
 * @Block(
 *   id = "regions_map_block",
 *   admin_label = "Carte régions",
 *   category = @Translation("Custom")
 * )
 */
class RegionsMapBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    // Chargement des groupes de type regional_group.
    $query = \Drupal::entityQuery('group');
    $query->condition('type', 'regional_group');
    $region_ids = $query->sort('label', 'ASC')->execute();
    $regions = Group::loadMultiple($region_ids);

    // Construction du tableau des données régions.
    $regions_data = array();
    foreach($regions as $region) {
      // Chargement du terme de taxonomie lié a chaque région pour en connaitre son poids
      $progress_term_id = $region->get('field_process_progress')->getString();
      $progress_term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($progress_term_id);

      $regions_data[$region->get('field_code')->getString()] = array(
        'id' => $region->id(),
        'name' => $region->label(),
        'progress' => $progress_term->getWeight()
      );
    }

    return [
      '#theme' => 'regions_map__block',
      '#data' => $regions_data,
      '#attached' => ['library' => ['arb_regions/regions-map']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }
}