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
	function getMenu()
	{
		$sidebar_menu = $this->Menus->find('threaded')->contain(['ParentMenus']);
		return $sidebar_menu;
	}
	
}
?>