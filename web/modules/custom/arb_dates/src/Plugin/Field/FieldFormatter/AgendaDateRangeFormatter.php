<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 17/10/19
 * Time: 18:38
 *
 * Custom module mainly based on the contrib module date_range_formatter.
 * ( https://www.drupal.org/project/date_range_formatter )
 * Thanks to maximpodorov ( https://www.drupal.org/u/maximpodorov ).
 */

/**
 * @file
 * Contains \Drupal\arb_dates\Plugin\Field\FieldFormatter\AgendaDateRangeFormatter
 */

namespace Drupal\arb_dates\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\datetime\Plugin\Field\FieldFormatter\DateTimeCustomFormatter;
use Drupal\datetime_range\DateTimeRangeTrait;

/**
 * Plugin implementation of the 'Custom' formatter for 'daterange' fields.
 *
 * This formatter renders the data range as plain text, with a fully
 * configurable date format using the PHP date syntax and separator.
 *
 * @FieldFormatter(
 *   id = "date_range_arb_agenda",
 *   label = @Translation("Dates Agenda ARB"),
 *   field_types = {
 *     "daterange"
 *   }
 * )
 */
class AgendaDateRangeFormatter extends DateTimeCustomFormatter {

  use DateTimeRangeTrait;

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'separator' => '---',
      'single' => 'à H:i',
      'one_day' => '\d\e H:i à {H}:{i}',
      'one_month' => '\d\u d à H:i \a\u {d} à {H}:{i}',
      'several_months' => '\d\u d F à H:i \a\u {d} {F} à {H}:{i}',
      'several_years' => 'd F Y - {d} {F} {Y}',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
//      dpm($item->start_date);
//      dpm($item->end_date);
      // Il y a une date de début et une date de fin.
      if (!empty($item->start_date) && !empty($item->end_date)) {
        /** @var \Drupal\Core\Datetime\DrupalDateTime $start_date */
        $start_date = $item->start_date->getTimestamp();
        /** @var \Drupal\Core\Datetime\DrupalDateTime $end_date */
        $end_date = $item->end_date->getTimestamp();

        if ($start_date !== $end_date) {
          $format = $this->getSetting('several_years');
          if (date('Y', $start_date) === date('Y', $end_date)) {
            $format = $this->getSetting('several_months');
          }
          if (date('m.Y', $start_date) === date('m.Y', $end_date)) {
            $format = $this->getSetting('one_month');
          }
          if (date('d.m.Y', $start_date) === date('d.m.Y', $end_date)) {
            $format = $this->getSetting('one_day');
          }

          $date_str = format_date($start_date, 'custom', preg_replace('/\{([a-zA-Z])\}/', '{\\\$1}', t($format)));
          $matches = array();
          if (preg_match_all('/\{([a-zA-Z])\}/', $date_str, $matches)) {
            foreach ($matches[1] as $match) {
              $date_str = preg_replace('/\{' . $match . '\}/', format_date($end_date, 'custom', $match), $date_str);
            }
          }
          $elements[$delta] = ['#markup' => '<span class="date-display-range">' . $date_str . '</span>',];

        }
        else {
          $elements[$delta] = ['#markup' => '<span class="date-display-range">'
            . date($this->getSetting('one_day'), $start_date)
            . '</span>'];
        }
      }
      // Il n'y a qu'une date de début.
      else {
        /** @var \Drupal\Core\Datetime\DrupalDateTime $start_date */
        $elements[$delta] = ['#markup' => '<span class="date-display-range">'
          . date($this->getSetting('single'), $start_date)
          . '</span>'];
      }
    }
    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form = parent::settingsForm($form, $form_state);
    unset($form['date_format']);
    $form['date_formats'] = [
      '#type' => 'fieldset',
      '#title' => 'Formats de date'
    ];
    $form['date_formats']['help'] = [
      '#type' => 'markup',
      '#markup' => t('A user-defined date format. See the <a href="@url">PHP manual</a> for available options.', ['@url' => 'http://php.net/manual/function.date.php']) .
        //'<br />' . t('Use letters in braces for end date elements, for example, {d} means the day of the end date.') .
        '<br />' . 'Utilisez le accolades pour la date de fin. Par exemple, {d} signifie le jour de la date de fin {F} signifie le nom complet du mois de la date de fin.',
    ];
    $form['date_formats']['single'] = [
      '#type' => 'textfield',
      //'#title' => t('Date format for single date'),
      '#title' => 'Date simple (pas de date de fin)',
      '#default_value' => $this->getSetting('single') ? : 'à H:i',
    ];
    $form['date_formats']['one_day'] = [
      '#type' => 'textfield',
      //'#title' => t('Date format for the single day date range'),
      '#title' => 'Dates de début et de fin le même jour',
      '#default_value' => $this->getSetting('one_day') ? : '\d\e H:i à {H}:{i}',
    ];
    $form['date_formats']['one_month'] = [
      '#type' => 'textfield',
      //'#title' => t('Date format for the single month date range'),
      '#title' => 'Dates de début et de fin le même mois',
      '#default_value' => $this->getSetting('one_month') ? : '\d\u d à H:i \a\u {d} à {H}:{i}',
    ];
    $form['date_formats']['several_months'] = [
      '#type' => 'textfield',
      //'#title' => t('Date format for the single year date range'),
      '#title' => 'Dates de début et de fin la même année',
      '#default_value' => $this->getSetting('several_months') ? : '\d\u d F à H:i \a\u {d} {F} à {H}:{i}',
    ];
    $form['date_formats']['several_years'] = [
      '#type' => 'textfield',
      //'#title' => t('Date format for multiple years date range'),
      '#title' => 'Dates de début et de fin sur des années différentes.',
      '#default_value' => $this->getSetting('several_years') ? : 'd F Y - {d} {F} {Y}',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = parent::settingsSummary();
    $summary[] = $this->t('Display date range using formats: @single, @one_day, @one_month, @several_months, @several_years',
      array(
        '@single' => $this->getSetting('single') ? : 'd F Y',
        '@one_day' => $this->getSetting('one_day') ? : 'd F Y',
        '@one_month' => $this->getSetting('one_month') ? : 'd - {d} F Y',
        '@several_months' => $this->getSetting('several_months') ? : 'd F - {d} {F} Y',
        '@several_years' => $this->getSetting('several_years') ? : 'd F Y - {d} {F} {Y}',
      )
    );

    return $summary;
  }
}