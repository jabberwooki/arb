<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 29/01/19
 * Time: 15:58
 */

/**
 * @file
 * Contains Drupal\arb_regions\Form\arb_regionsConfigForm
 */

namespace Drupal\arb_regions\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class MapsConfigForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'maps_config_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'arb_regions.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('arb_regions.settings');

    $form['arb_date'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Date carte ARB'),
      '#description' => 'Date de dernière mise à jour de la carte ARB',
      '#default_value' => $config->get('arb_date'),
    ];
    $form['srb_date'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Date carte SRB'),
      '#description' => 'Date de dernière mise à jour de la carte SRB',
      '#default_value' => $config->get('srb_date'),
    ];
    $form['ten_date'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Date carte TEN'),
      '#description' => 'Date de dernière mise à jour de la carte TEN',
      '#default_value' => $config->get('ten_date'),
    ];

    return parent::buildForm($form, $form_state);
  }

    /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('arb_regions.settings')
      ->set('arb_date', $form_state->getValue('arb_date'))
      ->set('srb_date', $form_state->getValue('srb_date'))
      ->set('ten_date', $form_state->getValue('ten_date'))
      ->save();
  }
}
