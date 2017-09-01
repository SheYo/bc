<?php
namespace Drupal\bethelks_staff\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class EditStaffForm extends FormBase {

  public function getFormId() {
    return 'bethelks_edit_staff_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state, $sid = null) {
    if(!is_numeric($sid)) {
      return $this->redirect("bethelks_staff.adminList");
    }

    $connection = \Drupal::service('database');
    $staffMember = $connection->query('SELECT * FROM `bethelks_staff` WHERE `sid` = :sid LIMIT 1', array(':sid' => $sid))->fetchAssoc();
    if(empty($staffMember)) {
      return $this->redirect("bethelks_staff.adminList");
    }

    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Name:'),
      '#required' => true,
      '#default_value' => $staffMember['name']
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
      '#required' => true,
      '#default_value' => $staffMember['staff_category']
    );
    $form['position'] = array(
      '#type' => 'textfield',
      '#title' => t('Position:'),
      '#required' => true,
      '#default_value' => $staffMember['position']
    );
    $form['extension'] = array(
      '#type' => 'textfield',
      '#title' => t('Extension:'),
      '#required' => false,
      '#default_value' => $staffMember['extension']
    );
    $form['telephone'] = array(
      '#type' => 'textfield',
      '#title' => t('Telephone (no dashes or parenthesis):'),
      '#required' => false,
      '#default_value' => $staffMember['telephone']
    );
    $form['campus_location'] = array(
      '#type' => 'textfield',
      '#title' => t('Location on Campus:'),
      '#required' => false,
      '#default_value' => $staffMember['campus_location']
    );
    $form['email'] = array(
      '#type' => 'textfield',
      '#title' => t('Email:'),
      '#required' => false,
      '#default_value' => $staffMember['email']
    );
    $form['bio'] = array(
      '#type' => 'textarea',
      '#title' => t('Bio:'),
      '#required' => false,
      '#default_value' => $staffMember['bio']
    );
    $form['sid'] = array(
      '#type' => 'hidden',
      '#value' => $sid
    );

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Update Employee'),
      '#button_type' => 'primary'
    );

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $connection = \Drupal::service('database');
    $emailExists = $connection->select('bethelks_staff')->condition(db_and()->condition('email', $form_state->getValue('email'), '=')->condition('sid', $form_state->getValue('sid'), '!='))->countQuery()->execute()->fetchField();

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
      $form_state->setErrorByName('email', $this->t('Another staff member already uses that email.'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $connection = \Drupal::service('database');

    if(empty($form_state->getValue('img'))) {
      $fields = array(
        'name' => $form_state->getValue('name'),
        'staff_category' => $form_state->getValue('staff_category'),
        'position' => $form_state->getValue('position'),
        'extension' => $form_state->getValue('extension'),
        'telephone' => $form_state->getValue('telephone'),
        'campus_location' => $form_state->getValue('campus_location'),
        'email' => $form_state->getValue('email'),
        'bio' => $form_state->getValue('bio')
      );
    }
    else {
      if ($form_state->getValue('img')!=null) {
        $image = $form_state->getValue('img');
        $this->configuration['image'] = $image;
        $file = \Drupal\file\Entity\File::load($image[0]);
        $file->setPermanent();
        $file->save();
        $img = $image[0];
      } else 
         $img = "";
      $fields = array(
        'name' => $form_state->getValue('name'),
        'img' => $img,
        'staff_category' => $form_state->getValue('staff_category'),
        'position' => $form_state->getValue('position'),
        'extension' => $form_state->getValue('extension'),
        'telephone' => $form_state->getValue('telephone'),
        'campus_location' => $form_state->getValue('campus_location'),
        'email' => $form_state->getValue('email'),
        'bio' => $form_state->getValue('bio')
      );
    }

    $updateStaffMember = $connection->update('bethelks_staff')->fields($fields)->condition('sid', $form_state->getValue('sid'), '=')->execute();

    drupal_set_message($this->t('"@emp_name" has been successfully updated', array('@emp_name' => $form_state->getValue('name'))));
  }
}
?>
