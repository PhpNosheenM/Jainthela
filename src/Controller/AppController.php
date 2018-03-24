<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
		
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
		$awsFileLoad=$this->loadComponent('AwsFile');
		$this->loadComponent('SidebarMenu');
		$this->set(compact('awsFileLoad'));  /// Use in ctp page
        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
       
		FrozenTime::setToStringFormat('dd-MM-yyyy hh:mm a');  // For any immutable DateTime
		FrozenDate::setToStringFormat('dd-MM-yyyy');  // For any immutable Date
		
		
		if($this->request->params['controller'] == 'Admins' or  $this->request->params['controller'] == 'admins') 
		{
			$this->loadComponent('Auth', [
			 'authenticate' => [
					'Form' => [
						'finder' => 'auth',
						'fields' => [
							'username' => 'username',
							'password' => 'password'
						],
						'userModel' => 'Admins'
					]
				],
				'loginAction' => [
					'controller' => 'Admins',
					'action' => 'login'
				],
				'loginRedirect' => [
					'controller' => 'Admins',
					'action' => 'index',
				],
				'logoutRedirect' => [
					'controller' => 'Admins',
					'action' => 'login'
				],
				'unauthorizedRedirect' => $this->referer(),
			]);
		}
		if($this->request->params['controller'] == 'Sellers' or  $this->request->params['controller'] == 'sellers') 
		{
			$this->loadComponent('Auth', [
			 'authenticate' => [
					'Form' => [
						'finder' => 'auth',
						'fields' => [
							'username' => 'username',
							'password' => 'password'
						],
						'userModel' => 'Sellers'
					]
				],
				'loginAction' => [
					'controller' => 'Admins',
					'action' => 'login'
				],
				'loginRedirect' => [
					'controller' => 'Sellers',
					'action' => 'index',
				],
				'logoutRedirect' => [
					'controller' => 'Sellers',
					'action' => 'login'
				],
				'unauthorizedRedirect' => $this->referer(),
			]);
		}
		else
		{
			$this->loadComponent('Auth');
		}
		
		
    }
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
		
		/*   Get Menu    */
		$sidebar_menu=$this->SidebarMenu->getMenu();
		
		$this->set(compact('sidebar_menu'));
	}
	
	public function stockReport($city_id = null,$from_date = null,$transaction_date = null)
    {
		$this->loadModel('Items');
		$user_id=$this->Auth->User('id'); 
		//$city_id=$this->request->query('city_id');
		//$location_id=$this->request->query('location_id');
		//$transaction_date=date("Y-m-d");
		
		 
		$showItems=[];
		
		if($city_id){
			 $Items = $this->Items->find()->toArray();
			// pr($Items); exit;
				foreach($Items as  $Item){
					if($Item->item_maintain_by=="itemwise"){
						$ItemLedgers =  $this->Items->ItemLedgers->find()->where(['item_id'=>$Item->id,'city_id'=>$city_id])->toArray();
						if($ItemLedgers){
							$UnitRateSerialItem = $this->itemWiseReport($Item->id,$transaction_date,$city_id);
							$showItems[$Item->id]=['item_name'=>$Item->name,'stock'=>$UnitRateSerialItem['stock'],'unit_rate'=>$UnitRateSerialItem['unit_rate']];
						}
						
					}else{
						$ItemsVariations=$this->Items->ItemsVariations->find()->contain(['UnitVariations'=>['Units']])->where(['item_id'=>$Item->id])->toArray();
						foreach($ItemsVariations as $ItemsVariation){
							$merge=$Item->name.'('.@$ItemsVariation->unit_variation->convert_unit_qty.'.'.@$ItemsVariation->unit_variation->unit->print_unit.')';
							$ItemLedgers =  $this->Items->ItemLedgers->find()->where(['item_id'=>$Item->id,'city_id'=>$city_id])->toArray();
							if($ItemLedgers){
							$UnitRateSerialItem = $this->itemVariationWiseReport($ItemsVariation->id,$transaction_date,$city_id);
							
							$showItems[$Item->id]=['item_name'=>$merge,'stock'=>$UnitRateSerialItem['stock'],'unit_rate'=>$UnitRateSerialItem['unit_rate']];
							}
						}
					}
				}
			
		}
		//pr($showItems); exit;
		$closingValue=0;
		foreach($showItems as $showItem){
			$closingValue+=$showItem['stock']*$showItem['unit_rate'];
			
		}
		return $closingValue;
		
	}

	public function itemVariationWiseReport($item_variation_id=null,$transaction_date,$city_id){ 
		$this->viewBuilder()->layout('admin_portal');
		//$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		
		$StockLedgers =  $this->Items->ItemLedgers->find()->where(['item_variation_id'=>$item_variation_id,'transaction_date <='=>$transaction_date])->order(['ItemLedgers.transaction_date'=>'ASC'])->toArray();
		
		 $stockNew=[];
		foreach($StockLedgers as $StockLedger){  
			if($StockLedger->status=='In'){ 
				$stockNew[]=['qty'=>$StockLedger->quantity,'rate'=>$StockLedger->rate];
			}
		}
		
		foreach($StockLedgers as $StockLedger){
			if($StockLedger->status=='Out'){	
				/* if(sizeof(@$stock) > 0){
					$stock= array_slice($stock, $StockLedger->quantity*100); 	
				} */
				
				if(sizeof(@$stockNew)==0){
				break;
				}
				
				$outQty=$StockLedger->quantity;
				a:
				if(sizeof(@$stockNew)==0){
					break;
				}
				$R=@$stockNew[0]['qty']-$outQty;
				if($R>0){
					$stockNew[0]['qty']=$R;
				}
				else if($R<0){
					unset($stockNew[0]);
					@$stockNew=array_values(@$stockNew);
					$outQty=abs($R);
					goto a;
				}
				else{
					unset($stockNew[0]);
					$stockNew=array_values($stockNew);
				}
			}
		}
		
		$closingValue=0;
		$total_amt=0;
		$total_stock=0;
		$unit_rate=0;
		foreach($stockNew as $qw){
			$total_stock+=$qw['qty'];
			$total_amt+=$qw['rate']*$qw['qty'];
		} 
		if($total_amt > 0 && $total_stock > 0){
			 $unit_rate = $total_amt/$total_stock; 
		}
		
		$Data=['stock'=>$total_stock,'unit_rate'=>$unit_rate];
		return $Data;
		exit;
	}
	public function itemWiseReport($item_id=null,$transaction_date,$city_id){ 
		$this->viewBuilder()->layout('admin_portal');
		//$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		
		$StockLedgers =  $this->Items->ItemLedgers->find()->where(['item_id'=>$item_id,'transaction_date <='=>$transaction_date,'city_id'=>$city_id])->order(['ItemLedgers.transaction_date'=>'ASC'])->toArray();
		 $stockNew=[];
		foreach($StockLedgers as $StockLedger){  
			if($StockLedger->status=='In'){ 
				$stockNew[]=['qty'=>$StockLedger->quantity,'rate'=>$StockLedger->rate];
			}
		}
		
		foreach($StockLedgers as $StockLedger){
			if($StockLedger->status=='Out'){	
				/* if(sizeof(@$stock) > 0){
					$stock= array_slice($stock, $StockLedger->quantity*100); 	
				} */
				
				if(sizeof(@$stockNew)==0){
				break;
				}
				
				$outQty=$StockLedger->quantity;
				a:
				if(sizeof(@$stockNew)==0){
					break;
				}
				$R=@$stockNew[0]['qty']-$outQty;
				if($R>0){
					$stockNew[0]['qty']=$R;
				}
				else if($R<0){
					unset($stockNew[0]);
					@$stockNew=array_values(@$stockNew);
					$outQty=abs($R);
					goto a;
				}
				else{
					unset($stockNew[0]);
					$stockNew=array_values($stockNew);
				}
			}
		}
		
		$closingValue=0;
		$total_stock=0;
		$unit_rate=0;
		$total_amt=0;
		foreach($stockNew as $qw){
			$total_stock+=$qw['qty'];
			$total_amt+=$qw['rate']*$qw['qty'];
		} 
		if($total_amt > 0 && $total_stock > 0){
			 $unit_rate = $total_amt/$total_stock; 
		}
		
		$Data=['stock'=>$total_stock,'unit_rate'=>$unit_rate];
		return $Data;
		exit;
	}
}
