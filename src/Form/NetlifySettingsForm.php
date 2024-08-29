<?php

declare(strict_types=1);

namespace Drupal\netlify\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Netlify settings for this site.
 */
final class NetlifySettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'netlify_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['netlify.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['build_hook_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Build Hook URL'),
      '#default_value' => $this->config('netlify.settings')->get('build_hook_url'),
      '#description' => $this->t('The configured build hook URL for Netlify.'),
    ];
    $form['enable_build'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable build trigger'),
      '#default_value' => $this->config('netlify.settings')->get('enable_build'),
      '#description' => $this->t('If enabled, the build hook for Netlify will be triggered in dependent events in Drupal.'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {}

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('netlify.settings')
      ->set('build_hook_url', $form_state->getValue('build_hook_url'))
      ->set('enable_build', $form_state->getValue('enable_build'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
