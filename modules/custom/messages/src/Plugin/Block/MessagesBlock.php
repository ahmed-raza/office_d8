<?php
/**
 * @file
 * Contains \Drupal\subscribe\Plugin\Block\CheckoutBlock.
 */
namespace Drupal\messages\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;

/**
 * Provides a 'Messages' block.
 *
 * @Block(
 *   id = "lists_messages",
 *   admin_label = @Translation("Messages"),
 *   category = @Translation("Messages from buyers.")
 * )
 */

class MessagesBlock extends BlockBase {
  public function build() {
    $uid = \Drupal::currentUser()->id();
    $messages = $this->getMessages($uid);
    $markup = '<ul>';
    foreach ($messages as $message) {
      $markup .= '<li>'.$message->name.'</li>';
    }
    $markup .= '</ul>';
    $build = array(
        '#type'=>'markup',
        '#markup'=>$markup
      );
    return $build;
  }

  private function getMessages($uid){
    $table = 'messages';
    $messages = db_select($table, 'messages')
                ->fields('messages')
                ->condition('uid', $uid, '=')
                ->execute()
                ->fetchAllAssoc('sid');
    return $messages;
  }
}
