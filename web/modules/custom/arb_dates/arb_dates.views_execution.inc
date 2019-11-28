<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 18/10/19
 * Time: 15:41
 */

//use Drupal\views\Plugin\views\field\Url;
//use Drupal\views\ViewExecutable;
//use Drupal\views\Plugin\views\query\QueryPluginBase;

/**
 * Implements hook_views_query_alter().
 *
 * Après test, il s'avère qu'on ne peut afficher un événement dans l'agenda qu'en se basant sur la date de début,
 * en en affichant cet événement uniquement dans le mois ou il démarre, meme s'il dure plusieurs mois.
 * Cette implémentation n'est donc pas utilisée, mais conservée comme exemple de code.
 */
//function arb_dates_views_query_alter(ViewExecutable $view, QueryPluginBase $query) {
//  // Vue Agenda.
//  if ($view->id() == 'events'  && $view->getDisplay()->display['id'] == 'events_list') {
//
//    $current_month = (explode('/', \Drupal::request()->getRequestUri()))[2];
//
//    // On filtre les événements par rapport à la valeur MSA = Mois Sélectionné dans l'Agenda.
//    // Les événements dont le mois de la date de début correspond à MSA sont déjà sélectionnés par le filtre contextuel de la vue Agenda.
//
//    // 2 - On ajoute les événéments dont le mois de la date de fin correspond à MSA.
//    $expression1 = "DATE_FORMAT((node__field_event_dates.field_event_dates_end_value + INTERVAL 7200 SECOND), '%Y%m') = $current_month";
//    $query->addWhereExpression(0, $expression1);
//
//    // 3 - On ajoute aussi les événement dont
//    // le mois de la date de début est antérieure à MSA
//    // ET (AND)
//    // le mois de la date de fin est postérieur à MSA.
//    $expression2 = "DATE_FORMAT((node__field_event_dates.field_event_dates_value + INTERVAL 7200 SECOND), '%Y%m') < $current_month"
//      . " AND DATE_FORMAT((node__field_event_dates.field_event_dates_end_value + INTERVAL 7200 SECOND), '%Y%m') > $current_month";
//    $query->addWhereExpression(0, $expression2);
//  }
//}