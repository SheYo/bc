<?php
namespace Drupal\bethelks_general_config\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class BethelKSConfigForm extends FormBase {

  public function getFormId() {
    return 'bethelks_general_config_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $connection = \Drupal::service('database');

    $configArray = array();
    $getConfig = $connection->query('SELECT * FROM `bethelks_site_config`');
    while($row = $getConfig->fetchAssoc()) {
      array_push($configArray, $row);
    }

    $form['config_fieldset'] = array(
      '#type' => 'fieldset',
      '#title' => t('Website Configuration')
    );

    foreach($configArray as $config) {
      $title = ucwords(str_replace('_', ' ', $config['config_key']));

      $form['config_fieldset'][$config['config_key']] = array(
        '#type' => 'textfield',
        '#title' => t($title),
        '#value' => $config['config_value'],
        '#required' => true
      );
    }

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Update Configuration'),
      '#button_type' => 'primary'
    );

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {

  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $connection = \Drupal::service('database');
    $getConfig = $connection->query('SELECT * FROM `bethelks_site_config`');

    while($row = $getConfig->fetchAssoc()) {
      $field = array(
        'config_value' => $_POST[$row["config_key"]]
      );

      $connection->update('bethelks_site_config')->fields($field)->condition('config_key', $row['config_key'], '=')->execute();
    }

    drupal_set_message($this->t("Successfully updated bethel website configuration."));
  }
}
?>
