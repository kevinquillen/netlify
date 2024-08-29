<?php

declare(strict_types=1);

namespace Drupal\netlify;

/**
 * Defines events for Netlify.
 */
final class NetlifyEvents {

  /**
   * Name of the event fired when saving an entity object.
   *
   * @var string
   */
  const CONTENT_ENTITY_SAVE = 'content.entity.save';

}
