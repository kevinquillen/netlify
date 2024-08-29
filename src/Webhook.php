<?php

declare(strict_types=1);

namespace Drupal\netlify;

use Drupal\Core\Config\ConfigFactoryInterface;
use GuzzleHttp\Client;

/**
 * Service to handle communicating to Netlify webhooks.
 */
final class Webhook {

  /**
   * Constructs a new Webhook instance.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The config factory service.
   * @param \GuzzleHttp\Client $httpClient
   *   The http client service.
   */
  public function __construct(protected ConfigFactoryInterface $configFactory, protected Client $httpClient) {}

  /**
   * Triggers a Netlify build and deploy.
   */
  public function build() {
    $netlify_config = $this->configFactory->get('netlify.settings');

    if ((bool) $netlify_config->get('enable_build')) {
      $build_hook_url = $netlify_config->get('build_hook_url');

      if (!empty($build_hook_url)) {
        $this->httpClient->post($build_hook_url, []);
      }
    }
  }

}
