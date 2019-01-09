<?php

namespace Drupal\annonce\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Annonce entities.
 */
class AnnonceViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.


      // Category
      $data['annonce_history']['table']['group'] = t('Annonce history');

      $data['annonce_history']['table']['provider'] = 'annonce';

      $data['annonce_history']['table']['base'] = [
          // Identifier (primary) field in this table for Views.
          'title' => t('Annonce history ID'),
          'field' => 'id',
          //Nom des donnees que l'on liste.
          // Label in the UI.
          'title' => t('Annonce history'),
          'weight' => -100,
      ];

      $data['annonce_history']['uid'] = [
          'title' => t('Annonce User ID'),
          'help' => t('Annonce User ID'),
          'field' => ['id' => 'numeric'],
          'sort' => ['id' => 'standard',],
          'filter' => [ 'id' => 'string',],

          'relationship' => [
              // Views name of the table to join to for the relationship.
              'base' => 'users_field_data',
              // Database field name in the other table to join on.
              'base field' => 'uid',
              // ID of relationship handler plugin to use.
              'id' => 'standard',
              // Default label for relationship in the UI.
              'label' => t('Annonce history UID -> USER ID'),
          ],
      ];


      $data['annonce_history']['aid'] = [
          'title' => t('Annonce ID'),
          'help' => t('Annonce ID'),
          'field' => ['id' => 'numeric'],
          'sort' => ['id' => 'standard',],
          'filter' => [ 'id' => 'string',],
          'argument' => [ 'id' => 'string',],
          'relationship' => [
              // Views name of the table to join to for the relationship.
              'base' => 'annonce_field_data',
              // Database field name in the other table to join on.
              'base field' => 'id',
              // ID of relationship handler plugin to use.
              'id' => 'standard',
              // Default label for relationship in the UI.
              'label' => t('Annonce history UID -> USER ID'),
          ],
      ];

      $data['annonce_history']['time'] = [
          'title' => t('Annonce Date'),
          'help' => t('Annonce Date'),
          'field' => ['id' => 'date'],
          'sort' => ['id' => 'standard',],
          'filter' => [ 'id' => 'string',],
          'argument' => [ 'id' => 'string',],
      ];


      return $data;
  }

}
