<?php

namespace Drupal\netlify\Event;

use Drupal\Component\EventDispatcher\Event;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Wraps a configuration event for event listeners.
 */
class ContentEntityEvent extends Event {

  /**
   * Constructs an event object.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The entity being saved.
   */
  public function __construct(protected ContentEntityInterface $entity) {}

  /**
   * Gets tne entity object.
   *
   * @return \Drupal\Core\Entity\ContentEntityInterface
   *   The entity being saved.
   */
  public function getEntity() {
    return $this->entity;
  }

}
