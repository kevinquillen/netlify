<?php

declare(strict_types=1);

namespace Drupal\netlify\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Url;
use Drupal\netlify\Webhook;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Triggers a webhook build in Netlify.
 */
final class TriggerBuildConfirmForm extends ConfirmFormBase {

  /**
   * Constructs a new confirm form.
   *
   * @param \Drupal\netlify\Webhook $webhook
   *   The webhook service.
   */
  public function __construct(protected Webhook $webhook) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('netlify.webhook'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'netlify_trigger_build_confirm';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion(): TranslatableMarkup {
    return $this->t('Do you want to trigger a full build in Netlify?');
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->t('This will trigger a build in Netlify. Note that a build can take up to 2 minutes to reflect on the Netlify frontend website.');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl(): Url {
    return new Url('system.admin_config');
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->webhook->build();
    $this->messenger()->addStatus($this->t('A build has been triggered. You can check the progress of your build at <a href=":url">:url</a>.', [':url' => 'https://app.netlify.com/']));
  }

}
