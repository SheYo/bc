<?php
namespace Drupal\bethelks_staff\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;

class AddStaffForm extends FormBase {

  public function getFormId() {
    return 'bethelks_add_staff_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#attributes']['enctype'] = "multipart/form-data";

    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Name:'),
      '#required' => true
    );
    $form['img'] = array(
      '#type' => 'managed_file',
      '#title' => t('Picture'),
      '#upload_validators' => array(
        'file_validate_extensions' => array('gif png jpg jpeg'),
        'file_validate_size' => array(25600000)
      ),
      '#upload_location' => 'public://staff-pictures',
      '#required' => false
    );
    $form['staff_category'] = array(
      '#type' => 'select',
      '#title' => t('Staff Category:'),
      '#options' => array(
        'admissions' => t('Admissions'),
        'administration' => t('Administration'),
        'financial_aid' => t('Financial Aid')
      ),
      '#required' => true
    );
    $form['position'] = array(
      '#type' => 'textfield',
      '#title' => t('Position:'),
      '#required' => true
    );
    $form['extension'] = array(
      '#type' => 'textfield',
      '#title' => t('Extension:'),
      '#required' => false
    );
    $form['telephone'] = array(
      '#type' => 'textfield',
      '#title' => t('Telephone (no dashes or parenthesis):'),
      '#required' => false
    );
    $form['campus_location'] = array(
      '#type' => 'textfield',
      '#title' => t('Location on Campus:'),
      '#required' => false
    );
    $form['email'] = array(
      '#type' => 'textfield',
      '#title' => t('Email:'),
      '#required' => false
    );
    $form['bio'] = array(
      '#type' => 'textarea',
      '#title' => t('Bio:'),
      '#required' => false
    );

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Add Employee'),
      '#button_type' => 'primary'
    );

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $connection = \Drupal::service('database');
    $emailExists = $connection->select('bethelks_staff')->condition('email', $form_state->getValue('email'), '=')->countQuery()->execute()->fetchField();

    if(strlen($form_state->getValue('extension')) !== 3) {
      $form_state->setErrorByName('extension', $this->t('Extension can only be 3 numbers long.'));
    }
    elseif(strlen($form_state->getValue('telephone')) < 10) {
      $form_state->setErrorByName('telephone', $this->t('Telephone number is too short.'));
    }
    elseif(!filter_var($form_state->getValue('email'), FILTER_VALIDATE_EMAIL)) {
      $form_state->setErrorByName('email', $this->t('Invalid email format.'));
    }
    elseif(intval($emailExists) != 0) {
      $form_state->setErrorByName('email', $this->t('Another staff member already uses that email. - ' . $emailExists));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('img')!=null) {
      $image = $form_state->getValue('img');
      $this->configuration['image'] = $image;
      $file = \Drupal\file\Entity\File::load($image[0]);
      $file->setPermanent();
      $file->save();
      $img = $image[0];
    } else 
       $img = "";
    $connection = \Drupal::service('database');
    $insertStaffMember = $connection->query(
      "INSERT INTO `bethelks_staff` VALUES(NULL, :name, :img, :staff_category, :position, :extension, :telephone, :campus_location, :email, :bio)",
      [
        ':name' => $form_state->getValue('name'),
        ':img' => $img,
        ':staff_category' => $form_state->getValue('staff_category'),
        ':position' => $form_state->getValue('position'),
        ':extension' => $form_state->getValue('extension'),
        ':telephone' => $form_state->getValue('telephone'),
        ':campus_location' => $form_state->getValue('campus_location'),
        ':email' => $form_state->getValue('email'),
        ':bio' => $form_state->getValue('bio')
      ]
    );

    drupal_set_message($this->t('"@emp_name" has been submitted as a valid staff member.', array('@emp_name' => $form_state->getValue('name'))));
  }
}
?>
