<?php

namespace Drupal\palaute\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Class PalauteForm.
 *
 * @package Drupal\palaute\Form
 */
class PalauteForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
   return 'palaute_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $conn = Database::getConnection();
     $record = array();
    if (isset($_GET['num'])) {
        $query = $conn->select('palaute', 'p')
            ->condition('id', $_GET['num'])
            ->fields('p');
        $record = $query->execute()->fetchAssoc();
      }

      $form['palautteenantajan_nimi'] = array(
        '#type' => 'textfield',
        '#title' => t('Nimi:'),
        '#required' => TRUE,
         //'#default_values' => array(array('id')),
        '#default_value' => (isset($record['nimi']) && $_GET['num']) ? $record['nimi']:'',
        );
      //print_r($form);die();
  
      $form['palautteenantajan_email'] = array(
        '#type' => 'email',
        '#title' => t('Email:'),
        '#required' => TRUE,
        '#default_value' => (isset($record['email']) && $_GET['num']) ? $record['email']:'',
        );
  
      $form['palautteenantajan_palaute'] = array (
        '#type' => 'textarea',
        '#title' => t('palaute:'),
        '#required' => TRUE,
        '#default_value' => (isset($record['palaute']) && $_GET['num']) ? $record['palaute']:'',
        );
      $form['submit'] = [
        '#type' => 'submit',
        '#value' => 'Lähetä',
        //'#value' => t('Submit'),
      ];
  
      return $form;
    }
  
    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {

      $nimi = $form_state->getValue('palautteenantajan_nimi');
          if(preg_match('/[^A-Öa-ö- ]/', $nimi)) {
             $form_state->setErrorByName('palautteenantajan_nimi', $this->t('nimi täytyy kirjoittaa vain kirjaimilla'));
          }
    parent::validateForm($form, $form_state);
  }
  /**
  * {@inheritdoc}
  */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $field=$form_state->getValues();
    $nimi=$field['palautteenantajan_nimi'];
    //echo "$nimi";
    $email=$field['palautteenantajan_email'];
    $palaute=$field['palautteenantajan_palaute'];
    $luotu = new DrupalDateTime();

  if (isset($_GET['num'])) {
    $field = array(
      'nimi' => $nimi,
      'email' => $email,
      'palaute' => $palaute,
      'luotu' => $luotu,
  );
  $query = \Drupal::database();
  $query->update('palaute')
      ->fields($field)
      ->condition('id', $_GET['num'])
      ->execute();
  drupal_set_message("muokkaus onnistui");
  $form_state->setRedirect('palaute.display_table_controller_display');
}
else
{
   $field = array(
      'nimi' => $nimi,
      'email' => $email,
      'palaute' => $palaute,
      'luotu' => $luotu,
);
 $query = \Drupal::database();
 $query ->insert('palaute')
     ->fields($field)
     ->execute();
 drupal_set_message("Kiitos yhteydenotostasi!");

/** $response = new RedirectResponse("/palaute/hello/table");
*   $response->send();
*/


}
}
}