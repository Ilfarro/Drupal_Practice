<?php

namespace Drupal\ata;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Mata pelajaran entity.
 *
 * @see \Drupal\ata\Entity\MataPelajaran.
 */
class MataPelajaranAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\ata\Entity\MataPelajaranInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished mata pelajaran entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published mata pelajaran entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit mata pelajaran entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete mata pelajaran entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add mata pelajaran entities');
  }

}
