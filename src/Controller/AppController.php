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
        $this->loadComponent('Security');
        $this->loadComponent('Csrf');
		$awsFileLoad=$this->loadComponent('AwsFile');
		$this->loadComponent('SidebarMenu');
		$EncryptingDecrypting=$this->loadComponent('EncryptingDecrypting');
		$this->set(compact('awsFileLoad','EncryptingDecrypting'));  /// Use in ctp page

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
       
		FrozenTime::setToStringFormat('dd-MM-yyyy hh:mm a');  // For any immutable DateTime
		FrozenDate::setToStringFormat('dd-MM-yyyy');  // For any immutable Date
		
		if($this->request->params['controller'] == 'SuperAdmins' or  $this->request->params['controller'] == 'SuperAdmins') 
		{
			$this->loadComponent('Auth', [
			 'authenticate' => [
					'Form' => [
						'finder' => 'auth',
						'fields' => [
							'username' => 'username',
							'password' => 'password'
						],
						'userModel' => 'SuperAdmins'
					]
				],
				'loginAction' => [
					'controller' => 'SuperAdmins',
					'action' => 'login'
				],
				'loginRedirect' => [
					'controller' => 'SuperAdmins',
					'action' => 'index',
				],
				'logoutRedirect' => [
					'controller' => 'SuperAdmins',
					'action' => 'login'
				],
				'unauthorizedRedirect' => $this->referer(),
			]);
		}
		
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
		
		$user_type=$this->Auth->User('user_type');
		//$sidebar_menu=$this->SidebarMenu->getMenu($user_type);
		$this->loadModel('Menus');
		$sidebar_menu=$this->Menus->find('threaded')->where(['status'=>1,'menu_for_user'=>$user_type]);
		
		$this->set(compact('sidebar_menu','user_type'));
	}
	public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
		
		/*   Get Menu    */
	}
	public function stockReportApp($city_id = null,$from_date = null,$transaction_date = null)
    { 
		$this->loadModel('Items');
		$user_id=$this->Auth->User('id');
		$this->viewBuilder()->layout('super_admin_layout');
		//$city_id=$this->request->query('city_id');
		//$location_id=$this->request->query('location_id');
		//$transaction_date=date("Y-m-d");
		
		//pr($city_id); exit; exit;
		$showItems=[];
		$showItems1=[];
		
		if($city_id){
			 $Items = $this->Items->find()->toArray();
		//$ItemsVariations=$this->Items->ItemsVariationsData->find()->toArray();//pr($ItemsVariations); exit;
				foreach($Items as  $Item){ 
					$ItemLedgers =  $this->Items->ItemLedgers->find()->where(['ItemLedgers.item_id'=>$Item->id,'ItemLedgers.city_id'=>$city_id,'ItemLedgers.seller_id IS NULL','ItemLedgers.transaction_date <='=>$transaction_date])->contain(['UnitVariations'=>['Units']])->first();
						if($ItemLedgers){  
							$UnitRateSerialItem = $this->itemWiseReport2($Item->id,$transaction_date,$city_id);
							$showItems[$Item->id]=['stock'=>$UnitRateSerialItem['stock'],'unit_rate'=>$UnitRateSerialItem['unit_rate']]; 
							
						}
				}
			
		}
		
		//$LocationData=$this->Items->Locations->get($location_id);
			$ItemsVariations=$this->Items->ItemsVariationsData->find()->toArray(); 
			foreach($ItemsVariations as  $ItemsVariation){  
					
						//$location_id=1;
						$ItemLedgers =  $this->Items->ItemLedgers->find()->where(['ItemLedgers.item_variation_id'=>$ItemsVariation->id,'ItemLedgers.city_id'=>$city_id,'ItemLedgers.location_id != '=>0,'ItemLedgers.seller_id IS NULL'])->contain(['Items','UnitVariations'=>['Units']])->first();
						
						if($ItemLedgers){  
							$UnitRateSerialItem = $this->itemVariationWiseReport1($ItemsVariation->id,$transaction_date,$ItemLedgers->location_id);
							$showItems1[$ItemsVariation->id]=['stock'=>$UnitRateSerialItem['stock'],'unit_rate'=>$UnitRateSerialItem[	'unit_rate']];
							//pr($showItems1);
					}
			}
		//exit;
		$closingValue=0;
		foreach($showItems as $showItem){  
			if(@$showItem['stock'][0] > 0){
				$closingValue+=$showItem['stock'][0]*$showItem['unit_rate'][0];
			}
			
		}
		
		$closingValue1=0;
		foreach($showItems1 as $showItem){ 
			if(@$showItem['stock'] > 0){
				$closingValue1+=$showItem['stock']*$showItem['unit_rate'];
			}
			
		}
		//pr($closingValue1); exit;
		return $closingValue+$closingValue1;
		
	}
	
		public function itemWiseReport2($item_id,$transaction_date,$city_id){
	
		$this->viewBuilder()->layout('super_admin_layout');
		//$city_id=$this->Auth->User('city_id');
		$location_id=$this->Auth->User('location_id');
	
		$ItemLedgers =  $this->Items->ItemLedgers->find()->where(['item_id'=>$item_id,'location_id'=>0,'seller_id IS NULL','transaction_date <='=>$transaction_date,'city_id'=>$city_id])->order(['ItemLedgers.transaction_date'=>'ASC'])->toArray(); 
		
			foreach($ItemLedgers as $ItemLedger){
					
					if($ItemLedger->status=="In"){
						for($inc=0;$inc<$ItemLedger->quantity;$inc++){
						$stock[$ItemLedger->unit_variation_id][]=$ItemLedger->rate;
						}
					}
				}
	
				foreach($ItemLedgers as $ItemLedger){
					if($ItemLedger->status=='Out'){
						if(sizeof(@$stock[$ItemLedger->unit_variation_id])>0){
							$stock[$ItemLedger->unit_variation_id] = array_slice($stock[$ItemLedger->unit_variation_id], $ItemLedger->quantity); 
						}
					}
				}
		
				$closingValue=0;
				$remaining=0;
				$item_var_val=[];
				$item_stock=[];
				foreach($stock  as $key=>$stockRow){ 
					$rate=0;
					foreach($stockRow as $data){  
						$remaining=count($stock[$key]); 
						$rate+=$data;
					}
					if($remaining > 0){
						$item_var_val[]=$rate/$remaining;
						$item_stock[]=$remaining;
					}
					
				}
		$Data=['stock'=>$item_stock,'unit_rate'=>$item_var_val]; //
		//pr($Data); exit;
		return $Data;
		exit;
	}

	public function itemVariationWiseReport1($item_variation_id=null,$transaction_date,$location_id){ 
		$this->viewBuilder()->layout('super_admin_layout');
		//$city_id=$this->Auth->User('city_id'); 
		//$location_id=$this->Auth->User('location_id'); 
		
		$StockLedgers =  $this->Items->ItemLedgers->find()->where(['item_variation_id'=>$item_variation_id,'transaction_date <='=>$transaction_date,'location_id'=>$location_id])->order(['ItemLedgers.transaction_date'=>'ASC'])->toArray();
		
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
	
	public function sellerStockItemVariationWiseReport($seller_id=null,$item_id,$item_variation_id){ 
		$this->viewBuilder()->layout('super_admin_layout');
		$this->loadModel('Items');
		$location_id=$this->Auth->User('location_id'); 
		$today_date=date("Y-m-d");
		$StockLedgers =  $this->Items->ItemLedgers->find()->where(['item_variation_id'=>$item_variation_id,'transaction_date <='=>$today_date])->order(['ItemLedgers.transaction_date'=>'ASC'])->toArray();
		
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
	
	public function sellerStockItemWiseReport($seller_id = null,$item_id = null){ 
		$this->loadModel('Items');
		$this->viewBuilder()->layout('super_admin_layout');
		//$city_id=$this->Auth->User('city_id'); 
		$location_id=$this->Auth->User('location_id'); 
		$today_date=date("Y-m-d");
		$StockLedgers =  $this->Items->ItemLedgers->find()->where(['item_id'=>$item_id,'transaction_date <='=>$today_date,'seller_id'=>$seller_id])->order(['ItemLedgers.transaction_date'=>'ASC'])->toArray();
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
	
	public function itemWiseReport1($item_id=null,$transaction_date,$city_id){ 
		$this->viewBuilder()->layout('super_admin_layout');
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
	
	public function GrossProfit($from_date = null,$to_date = null,$city_id = null,$location_id = null){
		$this->loadModel('AccountingEntries');
		$AccountingGroups=$this->AccountingEntries->Ledgers->AccountingGroups->find()->where(['AccountingGroups.nature_of_group_id IN'=>[3,4]]);
		$Groups=[];
		foreach($AccountingGroups as $AccountingGroup){
			$Groups[$AccountingGroup->id]['ids'][]=$AccountingGroup->id;
			$Groups[$AccountingGroup->id]['name']=$AccountingGroup->name;
			$Groups[$AccountingGroup->id]['nature']=$AccountingGroup->nature_of_group_id;
			$accountingChildGroups = $this->AccountingEntries->Ledgers->AccountingGroups->find('children', ['for' => $AccountingGroup->id]);
			foreach($accountingChildGroups as $accountingChildGroup){
				$Groups[$AccountingGroup->id]['ids'][]=$accountingChildGroup->id;
			}
		}
		$AllGroups=[];
		foreach($Groups as $mainGroups){
			foreach($mainGroups['ids'] as $subGroup){
				$AllGroups[]=$subGroup;
			}
		}
		
		$query=$this->AccountingEntries->find();
		$query->select(['ledger_id','totalDebit' => $query->func()->sum('AccountingEntries.debit'),'totalCredit' => $query->func()->sum('AccountingEntries.credit')])
				->group('AccountingEntries.ledger_id')
				->where(['AccountingEntries.city_id'=>$city_id,'AccountingEntries.transaction_date >='=>$from_date, 'AccountingEntries.transaction_date <='=>$to_date])
				->contain(['Ledgers'=>function($q){
					return $q->select(['Ledgers.accounting_group_id','Ledgers.id']);
				}]);
		$query->matching('Ledgers', function ($q) use($AllGroups){
			return $q->where(['Ledgers.accounting_group_id IN' => $AllGroups]);
		});
		$balanceOfLedgers=$query;
		//pr($query->toArray()); exit;
		$totalDr=0; $totalCr=0;
		foreach($balanceOfLedgers as $balanceOfLedger){
			$totalDr+=$balanceOfLedger->totalDebit;
			$totalCr+=abs($balanceOfLedger->totalCredit);
		}
		
		
		$openingValue= 0;
		$closingValue= $this->stockReportApp($city_id,$from_date,$to_date);
		
		
		$totalDr+=$openingValue;
		$totalCr+=$closingValue;
		
		return $totalCr-$totalDr;
	}
	
	public function differenceInOpeningBalance($city_id,$location_id){
		$this->loadModel('AccountingEntries');
		//pr($location_id); exit;
		$Ledgers=$this->AccountingEntries->find()->where(['AccountingEntries.location_id'=>$location_id, 'AccountingEntries.is_opening_balance'=>'yes']);
		
		$output=0;
		foreach($Ledgers as $Ledger){
			$output+=$Ledger->debit;
			$output-=$Ledger->credit;
		}
		
		$this->loadModel('ItemLedgers');
		$ItemLedgers=$this->ItemLedgers->find()->where(['ItemLedgers.location_id'=>$location_id, 'ItemLedgers.is_opening_balance'=> 'yes']);
		
		foreach($ItemLedgers as $ItemLedger){
			$output+=$ItemLedger->quantity*$ItemLedger->rate;
		}
		return $output;
	}
	
	public function StockValuationWithDate($date){
		$this->viewBuilder()->layout('super_admin_layout');
		$city_id=$this->Auth->User('city_id'); 
		
		$this->loadModel('Cities');
		$City=$this->Cities->get($city_id);
		
		$this->loadModel('ItemLedgers');
		if(strtotime($date)==strtotime($City->books_beginning_from)){ 
			$where=['ItemLedgers.city_id'=>$city_id,'ItemLedgers.transaction_date <='=>$date,'ItemLedgers.is_opening_balance'=>'yes'];
		}else{
			$where=['ItemLedgers.city_id'=>$city_id,'ItemLedgers.transaction_date <'=>$date];
		}
		
		$ItemLedgers=$this->ItemLedgers->find()->where($where); 
		$stock=[];
		//pr($date);pr($City->books_beginning_from); exit;
	//	pr($ItemLedgers->toArray()); exit;
		foreach($ItemLedgers as $ItemLedger){
			if($ItemLedger->status=="In"){
				for($inc=0;$inc<$ItemLedger->quantity;$inc++){
					$stock[$ItemLedger->item_id][]=$ItemLedger->rate;
				}
			}
		}
		
		foreach($ItemLedgers as $ItemLedger){
			if($ItemLedger->status=='Out'){
				if(sizeof(@$stock[$ItemLedger->item_id])>0){
					$stock[$ItemLedger->item_id] = array_slice($stock[$ItemLedger->item_id], $ItemLedger->quantity); 
				}
			}
		}
		$closingValue=0;
		foreach($stock as $stockRow){
			foreach($stockRow as $stockRowRate){
				$closingValue+=$stockRowRate;
			}
		}
		//pr($closingValue); exit;
		return $closingValue;
	}
}
