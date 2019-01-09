<?php

namespace Drupal\annonce;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Annonce entity.
 *
 * @see \Drupal\annonce\Entity\Annonce.
 */
class AnnonceAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\annonce\Entity\AnnonceInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished annonce entities')->addCacheableDependency($entity);
        }
        if($account->hasPermission('administer annonce entities')){
            return AccessResult::allowed()->cachePerUser();
        }
        return AccessResult::allowedIfHasPermission($account, 'view published annonce entities')->cachePerUser();

      case 'update':
        if($entity->getOwnerId() == $account->id()){
            return AccessResult::allowedIfHasPermission($account, 'edit own annonce entities')->addCacheableDependency($entity)->cachePerUser();
        }
        if($account->hasPermission('administer annonce entities')){
            return AccessResult::allowed()->cachePerUser();
        }
        return AccessResult::allowedIfHasPermission($account, 'edit annonce entities')->cachePerUser();

      case 'delete':
        if($entity->getOwnerId() == $account->id()){
            return AccessResult::allowedIfHasPermission($account, 'delete own annonce entities')->addCacheableDependency($entity)->cachePerUser();
        }
        if($account->hasPermission('administer annonce entities')){
            return AccessResult::allowed()->cachePerUser();
        }
        return AccessResult::allowedIfHasPermission($account, 'delete annonce entities')->cachePerUser();
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add annonce entities');
  }

}
