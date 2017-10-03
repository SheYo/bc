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
      '#upload_location' => 'public://staff-pictures/',
      '#default_value' => null,
      '#required' => false
    );
    $form['staff_category'] = array(
      '#type' => 'select',
      '#multiple' => true,
      '#title' => t('Staff Category:'),
      '#options' => array(
        'academic_affairs' => t('Academic Affairs'),
        'administration' => t('Administration'),
        'admissions' => t('Admissions'),
        'advancement' => t('Advancement'),
        'alumni_relations' => t('Alumni Relations'),
        'athletics' => t('Athletics'),
        'BCAPA' => t('BCAPA'),
        'bible_and_religion' => t('Bible and Religion'),
        'biology' => t('Biology'),
        'business_and_economics' => t('Business and Economics'),
        'business_office' => t('Business Office'),
        'business_services' => t('Business Services'),
        'cabinet' => t('Cabinet'),
        'center_for_academic_development' => t('Center for Academic Development'),
        'chemistry' => t('chemistry'),
        'communication_arts' => t('Communication Arts'),
        'english' => t('English'),
        'financial_aid' => t('Financial Aid'),
        'health_and_physical_education' => t('Health and Physical Education'),
        'history' => t('History'),
        'information_and_media_services' => t('Information and Media Services'),
        'Instituional Communications' => t('Institutional Communications'),
        'kauffman_museum' => t('Kauffman Museum'),
        'KIPCOR' => t('KIPCOR'),
        'languages' => t('Languages'),
        'library' => t('Library'),
        'maintenance' => t('Maintenance'),
        'mathematical_sciencs' => t('Mathematical Sciences'),
        'MLA' => t('MLA'),
        'music' => t('Music'),
        'nursing' => t('Nursing'),
        'office_services' => t('Office Services'),
        'president\'s_office' => t('President\'s Office'),
        'psychology' => t('Psychology'),
        'reigstrar\'s_office' => t('Registrar\'s Office'),
        'social_science' => t('Social Science'),
        'social_work' => t('Social Work'),
        'student_life' => t('Student Life'),
        'teacher_education' => t('Teacher Education'),
        'thresher_shop' => t('Thresher Shop'),
        'visual_art_and_design' => t('Visual Art and Design')
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

    // Gather the number of education in the form already.
    $num_education = $form_state->get('num_education');
    // We have to ensure that there is at least one education field.
    if ($num_education === NULL) {
      $education_field = $form_state->set('num_education', 1);
      $num_education = 1;
    }

    $form['#tree'] = TRUE;
    $form['education_fieldset'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Education'),
      '#prefix' => '<div id="education-fieldset-wrapper">',
      '#suffix' => '</div>',
    ];

    for ($i = 0; $i < $num_education; $i++) {
      $form['education_fieldset']['education'][$i] = [
        '#type' => 'textfield',
        '#title' => t('Education')
      ];
    }

    $form['education_fieldset']['actions'] = [
      '#type' => 'actions',
    ];
    $form['education_fieldset']['actions']['add_name'] = [
      '#type' => 'submit',
      '#value' => t('Add another field'),
      '#submit' => ['::addOne'],
      '#ajax' => [
        'callback' => '::addmoreCallback',
        'wrapper' => 'education-fieldset-wrapper',
      ],
    ];

    // If there is more than one education, add the remove button.
    if ($num_education > 1) {
      $form['education_fieldset']['actions']['remove_education'] = [
        '#type' => 'submit',
        '#value' => t('Remove last field'),
        '#submit' => ['::removeCallback'],
        '#ajax' => [
          'callback' => '::addmoreCallback',
          'wrapper' => 'education-fieldset-wrapper',
        ],
      ];
    }

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Add Employee'),
      '#button_type' => 'primary'
    );

    return $form;
  }
  
  /**
   * Callback for both ajax-enabled buttons.
   *
   * Selects and returns the fieldset with the names in it.
   */
  public function addmoreCallback(array &$form, FormStateInterface $form_state) {
    $education_field = $form_state->get('num_education');
    return $form['education_fieldset'];
  }

  /**
   * Submit handler for the "add-one-more" button.
   *
   * Increments the max counter and causes a rebuild.
   */
  public function addOne(array &$form, FormStateInterface $form_state) {
    $education_field = $form_state->get('num_education');
    $add_button = $education_field + 1;
    $form_state->set('num_education', $add_button);
    $form_state->setRebuild();
  }

  /**
   * Submit handler for the "remove one" button.
   *
   * Decrements the max counter and causes a form rebuild.
   */
  public function removeCallback(array &$form, FormStateInterface $form_state) {
    $education_field = $form_state->get('num_education');
    if ($education_field > 1) {
      $remove_button = $education_field - 1;
      $form_state->set('num_education', $remove_button);
    }
    $form_state->setRebuild();
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {

  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    if($form_state->getValue('img') != null) {
      $image = $form_state->getValue('img');
      $file = \Drupal\file\Entity\File::load($image[0]);
      $file->setPermanent();
      $file->save();
      $img = $image[0];
    }
    else {
      $img = "";
    }

    $connection = \Drupal::service('database');
    $insertStaffMember = $connection->query(
      "INSERT INTO `bethelks_staff` VALUES(NULL, :name, :img, :position, :extension, :telephone, :campus_location, :email, :bio)",
      [
        ':name' => $form_state->getValue('name'),
        ':img' => $img,
        ':position' => $form_state->getValue('position'),
        ':extension' => $form_state->getValue('extension'),
        ':telephone' => $form_state->getValue('telephone'),
        ':campus_location' => $form_state->getValue('campus_location'),
        ':email' => $form_state->getValue('email'),
        ':bio' => $form_state->getValue('bio')
      ]
    );

    $staff_id = $connection->query("SELECT sid FROM {bethelks_staff} ORDER BY sid DESC LIMIT 1")->fetchField(0);

    $staff_category_values = $form_state->getValue('staff_category');
    foreach($staff_category_values as $staff_category) {
      if($staff_category == null) continue;
      $insertCategory = $connection->query(
        "INSERT INTO `bethelks_staff_category` VALUES(NULL, :staff_id, :category)",
        [
          ':staff_id' => $staff_id,
          ':category' => $staff_category
        ]
      );
    }

    $education_values = $form_state->getValue(['education_fieldset', 'education']);
    if(!empty($education_values)) {
      foreach($education_values as $education) {
        if($education == null) continue;
        $insertEducation = $connection->query(
          "INSERT INTO `bethelks_staff_education` VALUES(NULL, :staff_id, :education)",
          [
            ':staff_id' => $staff_id,
            ':education' => $education
          ]
        );
      }
    }

    drupal_set_message($this->t('"@emp_name" has been submitted as a valid staff member.', array('@emp_name' => $form_state->getValue('name'))));
  }
}
?>
