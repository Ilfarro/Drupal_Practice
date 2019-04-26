<?php

namespace Drupal\ata;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Challenge entity.
 *
 * @see \Drupal\ata\Entity\Challenge.
 */
class ChallengeAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\ata\Entity\ChallengeInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished challenge entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published challenge entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit challenge entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete challenge entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add challenge entities');
  }

}
