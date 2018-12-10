<?php
namespace Drupal\palaute\Plugin\Block;
use Drupal\Core\Block\BlockBase;
/**
 * Provides a 'PalauteBlock' block.
 *
 * @Block(
 * id = "palaute_block",
 * admin_label = @Translation("Palaute block"),
 * )
 */
class PalauteBlock extends BlockBase {
 /**
 * {@inheritdoc}
 */
  public function build() {
 ////$build = [];
 //$build['palaute_block']['#markup'] = 'Implement PalauteBlock.';

$form = \Drupal::formBuilder()->getForm('Drupal\palaute\Form\PalauteForm');

return $form;
 }
}