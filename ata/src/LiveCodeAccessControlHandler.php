<?php

namespace Drupal\ata;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Live code entity.
 *
 * @see \Drupal\ata\Entity\LiveCode.
 */
class LiveCodeAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\ata\Entity\LiveCodeInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished live code entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published live code entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit live code entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete live code entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add live code entities');
  }

}
