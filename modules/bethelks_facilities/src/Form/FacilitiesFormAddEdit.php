<?php
namespace Drupal\bethelks_facilities\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\bethelks_facilities\BethelksFacilityModel;

class FacilitiesFormAddEdit extends FormBase {

  public function getFormId() {
    return 'bethelks_add_staff_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state, $id = null) {
    if ($id == 0) {
      $data = array('title'=>'', 'mapid'=>'', 'description'=>'', '');
    } else {
      $data = BethelksFacilityModel::GetView($id);
    }

    $form['#attributes']['enctype'] = "multipart/form-data";

    $form['id'] = array(
      '#type'=>'hidden',
      '#value'=>$id
    );

    $form['title'] = array(
      '#type' => 'textfield',
      '#title' => t('Title:'),
      '#required' => true,
      '#default_value' => $data['title']
    );

    $form['mapid'] = array(
        '#type' => 'textfield',
        '#title' => t('Map ID:'),
        '#required' => true,
        '#default_value' => $data['mapid']
    );

    $form['description'] = array(
        '#type' => 'textarea',
        '#title' => t('Description:'),
        '#required' => true,
        '#default_value' => $data['description']
    );

    $form['picture'] = array(
      '#type' => 'managed_file',
      '#title' => t('Picture'),
      '#upload_validators' => array(
        'file_validate_extensions' => array('gif png jpg jpeg'),
        'file_validate_size' => array(25600000)
      ),
      '#upload_location' => 'public://facility-pictures',
      '#required' => false
    );

    $form['actions']['submit'] = array(
        '#type' => 'submit',
        '#value' => $this->t('Submit'),
        '#button_type' => 'primary'
    );
    return $form;
  }

 // public function validateForm(array &$form, FormStateInterface &$form_state) { }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    // if image not suply set image to empty
    if ($form_state->getValue('picture') != null) {
      $image = $form_state->getValue('picture');
      $this->configuration['image'] = $image;
      $file = \Drupal\file\Entity\File::load($image[0]);
      $file->setPermanent();
      $file->save();
      $img = $image[0];
    } else {
      $img = '';
    }
    BethelksFacilityModel::InsertEdit($form_state->getValue('id'), $form_state->getValue('mapid'), $form_state->getValue('title'), $form_state->getValue('description'),  $img);
  }
}
?>
