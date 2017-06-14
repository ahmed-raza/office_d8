<?php
/**
 * @file
 * Contains \Drupal\subscribe\Plugin\Block\CheckoutBlock.
 */
namespace Drupal\messages\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;

/**
 * Provides a 'Messages Form' block.
 *
 * @Block(
 *   id = "messages",
 *   admin_label = @Translation("Message"),
 *   category = @Translation("Message form for buyers.")
 * )
 */

class MessagesFormBlock extends BlockBase {
  public function build() {
    return \Drupal::formBuilder()->getForm('Drupal\messages\Form\MessagesForm');
  }
}
