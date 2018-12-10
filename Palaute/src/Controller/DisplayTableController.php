<?php

namespace Drupal\palaute\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;

/**
 * Class DisplayTableController.
 *
 * @package Drupal\palaute\Controller
 */

class DisplayTableController extends ControllerBase {

  public function display() {

    //create table header
    $header_table = array(
    // 'id'=>    t('SrNo'),
      'nimi' => t('Nimi'),
       'email'=>t('Email'),
        'palaute' => t('Palaute'),
        'luotu' => t('Luotu'),
        'opt' => t('toiminto'),
        'opt1' => t('toiminto'),
    );

//select records from table
    $query = \Drupal::database()->select('palaute', 'p');
      $query->fields('p', ['id','nimi','email','palaute','luotu']);
      $results = $query->execute()->fetchAll();
        $rows=array();
    foreach($results as $data){
        $delete = Url::fromUserInput('/palaute/form/delete/'.$data->id);
        $edit   = Url::fromUserInput('/palaute/form/palaute?num='.$data->id);

         //print the data from table
         $rows[] = array(
          //'id' =>$data->id,
               'nimi' => $data->nimi,
               'email' => $data->email,
                'palaute' => $data->palaute,
                'luotu' => $data->luotu,

                \Drupal::l('Poista', $delete),
                \Drupal::l('Muokkaa', $edit),
           );

   }
   //display data in site
   $form['table'] = [
           '#type' => 'table',
           '#header' => $header_table,
           '#rows' => $rows,
           '#empty' => t('Ei löytynyt'),
       ];
//        echo '<pre>';print_r($form['table']);exit;
       return $form;

 }

}