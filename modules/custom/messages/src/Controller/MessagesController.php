<?php 

namespace Drupal\messages\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use \Drupal\Core\Link;

class MessagesController extends ControllerBase {
  public function messages(){
    $user = \Drupal::currentUser();
    if (!$user->isAnonymous()) {
      return $this->page();
    }else{
      throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
    }
  }

  private function page(){
    $build = array(
      '#type' => 'markup',
      '#markup' => t('List of your messages.'),
    );

    $header = array(
      'name' => t('Name'),
      'email' => t('Email'),
      'phone' => t('Phone'),
      'message' => t('Message'),
      );

    $rows = array();
    $uid = \Drupal::currentUser()->id();
    $messages = $this->getMessages($uid);
    foreach ($messages as $message) {
      $row = array();
      $row['name'] = $message->name;
      $row['mail'] = $message->mail;
      $row['phone'] = $message->phone;
      $row['message'] = $message->message;
      $rows[] = $row;
    }
    $table = array(
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#attributes' => array(
        'id' => 'messages-listing-table',
        ),
      );

    $final = array($filterForm, $operationsForm, $build, $table);

    return $final;
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
