<?php
/**
 * @file
 * Contains \Drupal\messages\Form\ContactForm.
 */

namespace Drupal\messages\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;


/**
 * My Form.
 */
class MessagesForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'messages_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $current_uid = \Drupal::currentUser()->id();
    $current_user = user_load($current_uid);
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Name'),
      '#required' => TRUE,
      '#default_value' => $current_user->getUsername(),
    );
    $form['mail'] = array(
      '#type' => 'textfield',
      '#title' => t('Email'),
      '#required' => TRUE,
      '#default_value' => $current_user->getEmail(),
    );
    $form['phone'] = array(
      '#type' => 'textfield',
      '#title' => t('Phone'),
      '#required' => TRUE
    );
    $form['message'] = array(
      '#type' => 'textarea',
      '#title' => t('Message'),
      '#required' => TRUE,
    );
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Send'),
      '#attributes' => array(
        'class'=>array('btn-primary btn-block')
        ),
    );
    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Validating mail address
    if (!valid_email_address($form_state->getValue('mail'))) {
      $form_state->setErrorByName('mail', $this->t('The email is not valid.'));
    }
    // Validating phone number
    if (!preg_match("/^0\d{9}$/", $form_state->getValue('phone'))) {
      $form_state->setErrorByName('phone', $this->t('The phone number is not valid.'));
    }
    // Validating message length
    if (strlen($form_state->getValue('message')) < 10) {
      $form_state->setErrorByName('message', $this->t('The message is too short.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Storing form data to database.
    $node = \Drupal::request()->attributes->get('node');
    $table = 'messages';
    $data = array(
      'uid' => $node->getOwnerId(),
      'name' => $form_state->getValue('name'),
      'mail' => $form_state->getValue('mail'),
      'phone' => $form_state->getValue('phone'),
      'message' => $form_state->getValue('message'),
      );
    $query = db_insert($table)->fields($data)->execute();
    if ($query) {
      drupal_set_message(t('Your message has been sent.'));
    }
    else{
      drupal_set_message(t('Internal Error! message sending failed.'), 'warning');
    }
  }
}
