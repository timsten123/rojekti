<?php

namespace Drupal\palaute\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;
use Drupal\Core\Render\Element;

/**
 * Class DeleteForm.
 *
 * @package Drupal\palaute\Form
 */
class DeleteForm extends ConfirmFormBase {
/**
 * {@inheritdoc}
 */
 public function getFormId() {
 return 'delete_form';
 }
 public $cid;
 public function getQuestion() {
 return t('Haluatko poistaa %cid?', array('%cid' => $this->cid));
 }
 public function getCancelUrl() {
 return new Url('palaute.display_table_controller_display');
}
public function getDescription() {
 return t('Tee vain, jos olet aivan varma!');
 }
 /**
 * {@inheritdoc}
 */
 public function getConfirmText() {
 return t('Poista');
}

/**
 * {@inheritdoc}
 */
 public function getCancelText() {
 return t('Peruuta');
 }

/**
 * {@inheritdoc}
 */
 public function buildForm(array $form, FormStateInterface $form_state, $cid = NULL) {

$this->id = $cid;
 return parent::buildForm($form, $form_state);
 }

/**
* {@inheritdoc}
 */
public function validateForm(array &$form, FormStateInterface $form_state) {
  parent::validateForm($form, $form_state);
  }
 
 /**
  * {@inheritdoc}
  */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  $query = \Drupal::database();
  $query->delete('palaute')
  ->condition('id',$this->id)
  ->execute();
  drupal_set_message("onnistuneesti poistettu");
  $form_state->setRedirect('palaute.display_table_controller_display');
  }
 }
 