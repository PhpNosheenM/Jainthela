<?php
namespace App\Controller\Component;
use App\Controller\AppController;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
class SidebarMenuComponent extends Component
{
	function initialize(array $config) 
	{
		parent::initialize($config);
		$this->Menus = TableRegistry::get('Menus');
	}
	function getMenu($user_type)
	{
		$sidebar_menu = $this->Menus->find('threaded')->where(['Menus.menu_for_user'=>$user_type])->contain(['ParentMenus']);
		return $sidebar_menu;
	}
	
}
?>