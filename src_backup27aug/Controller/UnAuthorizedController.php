<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;

/**
 * UnAuthorized Controller
 *
 */
class UnAuthorizedController extends AppController
{
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
		
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['unAuthorized']);
    }
	public function unAuthorized()
	{
		$this->viewBuilder()->layout('unauthorized_layout');
		
	}
}
?>