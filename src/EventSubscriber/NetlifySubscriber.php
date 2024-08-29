<?php

declare(strict_types=1);

namespace Drupal\netlify\EventSubscriber;

use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Config\ConfigEvents;
use Drupal\netlify\Event\ContentEntityEvent;
use Drupal\netlify\NetlifyEvents;
use Drupal\netlify\Webhook;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event subscriber for responding to events to trigger Netlify builds.
 */
final class NetlifySubscriber implements EventSubscriberInterface {

  /**
   * Constructs a new event subscriber instance.
   *
   * @param \Drupal\netlify\Webhook $webhook
   *   The webhook trigger service.
   */
  public function __construct(protected Webhook $webhook) {}

  /**
   * Config save event handler.
   */
  public function onConfigSave(ConfigCrudEvent $event): void {
    $this->triggerNetlifyBuild();
  }

  /**
   * Content entity save event handler.
   */
  public function onContentEntitySave(ContentEntityEvent $event): void {
    $this->triggerNetlifyBuild();
  }

  /**
   * Triggers a Netlify build and deploy.
   */
  private function triggerNetlifyBuild() {
    $this->webhook->build();
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      ConfigEvents::SAVE => ['onConfigSave'],
      NetlifyEvents::CONTENT_ENTITY_SAVE => ['onContentEntitySave'],
    ];
  }

}
