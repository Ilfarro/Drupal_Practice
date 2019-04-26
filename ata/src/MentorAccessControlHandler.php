<?php

namespace Drupal\ata;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Mentor entity.
 *
 * @see \Drupal\ata\Entity\Mentor.
 */
class MentorAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\ata\Entity\MentorInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished mentor entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published mentor entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit mentor entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete mentor entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add mentor entities');
  }

}
