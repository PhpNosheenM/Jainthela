<?php
namespace App\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\View;

/**
 * AppNotifications Controller
 *
 * @property \App\Model\Table\AppNotificationsTable $AppNotifications
 *
 * @method \App\Model\Entity\AppNotification[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AppNotificationsController extends AppController
{
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->setConfig('unlockedActions', ['index','test']);

    }
	
	 public function test()
	 {
		 $device_token='eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjQsImV4cCI6MTUyODcyMjU2MH0.WWSaEid7dpeaYjCE_KiRkPkHxymT8QvJKaqYkgm85e0';
		 if(!empty($device_token)){
		$msg = array
		(
			'message'     =>'100% CashBack Offer on Order above 300 Rs. Order Now',
			'image'     =>'',
			'link'    => '/jainthela://home',
			'notification_id'    => '1',
		);
		$url = 'https://fcm.googleapis.com/fcm/send';
		$fields = array
		(
			'registration_ids'     => array($device_token),
			'data'            => @$msg,
		);				 
		 		 
 
        //$url = 'https://fcm.googleapis.com/fcm/send';
  
        $kkkki="cfroufH_wtc:APA91bFjkWZ0WG_xvcLrtkAG3hheQK0tUipIPufdCYT85UkzhRyL_vEn8nOK--0zTj1w1b6OTcvnv81PhxFe4jgEpyAAwlHZ8MQvJBznCQLIAi4RD30vphR8uiZFWrzZ3SVVnYPjRSla";
		
        $headers = array(
            'Authorization: key=' . $kkkki,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);   
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
		pr($result); 		
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        echo $result;
    	 			
		 }			
		 
	 }
	 
	 
	 
	 
	public function indexAll()
    {
		//$server_path=$this->request->here();
		$server_path='http://13.126.159.20/';
		$user_id=$this->Auth->User('id');
        $city_id=$this->Auth->User('city_id');
        $location_id=$this->Auth->User('location_id'); 
        $state_id=$this->Auth->User('state_id'); 
        $this->viewBuilder()->layout('super_admin_layout');
		$appNotification = $this->AppNotifications->newEntity();
		
        $this->paginate = [
            'contain' => ['Cities'],
			'limit' => 20
        ];
		
		if ($this->request->is(['post','put'])) {
			 
			
			$image_web=$this->request->data['image_web'];
			$send_type=$this->request->data['send_type'];
			@$main_customer_ids=$this->request->data['customer_id'];
			 
			$web_image_error=$image_web['error'];
			
            $appNotification = $this->AppNotifications->patchEntity($appNotification, $this->request->getData());
			if(empty($web_image_error))
			{
				$banner_ext=explode('/',$image_web['type']);
				$banner_image_name='AppNotifications'.time().'.'.$banner_ext[1];
			}

				$appNotification->city_id=$city_id;
				//$appNotification->location_id=$location_id;
				$appNotification->location_id=1;
				$appNotification->created_by=$user_id;
			 	//pr($appNotification->toArray()); exit;
				$link_name=$this->request->data['link_name'];
				$category_id=$this->request->data['category_id'];
				$item_id=$this->request->data['item_id'];
				$item_variation_id=$this->request->data['item_variation_id'];
				$combo_offer_id=$this->request->data['combo_offer_id'];
				if($link_name=='product_description'){
					
					$dummy_link='/jainthela://'.$link_name.'?id='.$item_id.'&var_id='.$item_variation_id.'&cat_id='.$category_id;
					
				}else if($link_name=='combo_description'){
					
					$dummy_link='/jainthela://'.$link_name.'?id='.$combo_offer_id;
					
				}else if($link_name=='category_wise'){
					
					$dummy_link='/jainthela://'.$link_name.'?id='.$category_id;
					
				}else if($link_name=='item_wise'){
					
					$dummy_link='/jainthela://'.$link_name.'?id='.$item_id;
					
				}else if($link_name=='combo'){
					
					$dummy_link='/jainthela://'.$link_name.'?id='.$item_id;
					
				}else if($link_name=='store_item_wise'){
					
					$dummy_link='/jainthela://'.$link_name.'?id='.$category_id;
					
				}else{
					
					$dummy_link='/jainthela://'.$link_name;
				}
				$appNotification->app_link=$dummy_link;
            if ($banner_data=$this->AppNotifications->save($appNotification)) {
			
				if(empty($web_image_error))
				{
					/* For Web Image */
					$deletekeyname = 'AppNotifications/'.$banner_data->id.'/web';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'AppNotifications/'.$banner_data->id.'/web/'.$banner_image_name;
					$this->AwsFile->putObjectFile($keyname,$image_web['tmp_name'],$image_web['type']);
					$banner_data->image_web=$keyname;
					$this->AppNotifications->save($banner_data);

					/* Resize Image */
					$destination_url = WWW_ROOT . 'img/temp/'.$banner_image_name;
					if($banner_ext[1]=='png'){
						$image = imagecreatefrompng($image_web['tmp_name']);
					}else{
						$image = imagecreatefromjpeg($image_web['tmp_name']); 
					}
					$im = imagejpeg($image, $destination_url, 10);
					
					
					/* For App Image */
					$deletekeyname = 'AppNotifications/'.$banner_data->id.'/app';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'AppNotifications/'.$banner_data->id.'/app/'.$banner_image_name;
					$this->AwsFile->putObjectFile($keyname,$image_web['tmp_name'],$image_web['type']);
					$banner_data->image_app=$keyname;
					$this->AppNotifications->save($banner_data);

					$dir  = WWW_ROOT .  'img'.DS.'temp'.DS.$banner_image_name;
                    $dir = $this->EncryptingDecrypting->encryptData($dir);
				}else{
					$keyname='img/jain.png';
				}
				
					$image_result=$this->AwsFile->getObjectFile($keyname);
					$img_url='data:'.$image_result['ContentType'].';base64,'.base64_encode($image_result['Body']);
					$customers_data=$this->AppNotifications->Customers->find()->where(['Customers.city_id'=>$city_id]);
					
					$final_link=$banner_data->app_link;
					if(!empty($final_link)){
						$created_link=$final_link;
					}else{
						$created_link='/jainthela://home';
					}
					
					$message=$banner_data->message;
					$title=$banner_data->title;
					
					$API_ACCESS_KEY='AAAAXmNqxY4:APA91bG0X6RHVhwJKXUQGNSSCas44hruFdR6_CFd6WHPwx9abUr-WsrfEzsFInJawElgrp24QzaE4ksfmXu6kmIL6JG3yP487fierMys5byv-I1agRtMPIoSqdgCZf8R0iqsnds-u4CU';
					
					//define('SERVER_API_KEY','AIzaSyDQcVP0eF_55UrqTxYOAmdeeEzt2lQ6PAg');		
					//define('SERVER_API_KEY','AAAAXmNqxY4:APA91bG0X6RHVhwJKXUQGNSSCas44hruFdR6_CFd6WHPwx9abUr-WsrfEzsFInJawElgrp24QzaE4ksfmXu6kmIL6JG3yP487fierMys5byv-I1agRtMPIoSqdgCZf8R0iqsnds-u4CU');		
					
					
					
					$tokens_data=$this->AppNotifications->AppNotificationTokens->find()->where(['AppNotificationTokens.city_id'=>$city_id]);
					
					foreach($tokens_data as $tkn_data){
						
						$web_token=$tkn_data->web_token;
						$app_token=$tkn_data->app_token;
						
						if(($web_token!='NULL')){
							
							define('SERVER_API_KEY','AIzaSyDQcVP0eF_55UrqTxYOAmdeeEzt2lQ6PAg');		
						}
						if(($app_token!='NULL')){
							
							define('SERVER_API_KEY','AAAAXmNqxY4:APA91bG0X6RHVhwJKXUQGNSSCas44hruFdR6_CFd6WHPwx9abUr-WsrfEzsFInJawElgrp24QzaE4ksfmXu6kmIL6JG3yP487fierMys5byv-I1agRtMPIoSqdgCZf8R0iqsnds-u4CU');
						}
						//$device_token='fiv6reOde8w:APA91bGqiTQMcu9_U19hqGYOU7EioP4US-uIBDWpFvgSIk02mJc2xxK_Ervmp6BgFHMH3dapxgsnpDFjx7UfjykubJYueoeFAuXya85yMzMhU33IOdQqXjrl51Z-QMW7PoYNc6-VgbNo';
						//$device_token="cfroufH_wtc:APA91bFjkWZ0WG_xvcLrtkAG3hheQK0tUipIPufdCYT85UkzhRyL_vEn8nOK--0zTj1w1b6OTcvnv81PhxFe4jgEpyAAwlHZ8MQvJBznCQLIAi4RD30vphR8uiZFWrzZ3SVVnYPjRSla";
						$device_token1=rtrim($device_token);
						 
		if(($web_token!='NULL') || ($app_token!='NULL')){
			
			
	$tokens = array($device_token);

	$header = [
		'Content-Type:application/json',
		'Authorization: Key='.SERVER_API_KEY
	];

	$msg = [
		'title'=> $title,
		'body' => 'HELLO WORLD'.$message,
		'message' => 'HELLO WORLD'.$message,
		'icon' => $server_path.$keyname,
		'url' => 'img/jain.png'
	];
	
	$payload = array(
		'registration_ids' => $tokens,
		'data' => $msg
	);
	
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => json_encode($payload),
	  CURLOPT_HTTPHEADER => $header
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	pr($payload);
	$final_result=json_decode($response);
	$sms_flag=$final_result->success; 	
	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  echo $response;
	}			
			   
						 }
					
					}
					 
					
				exit;
                $this->Flash->success(__('The AppNotifications has been saved.'));

                if(empty($web_image_error))
                {
                 return $this->redirect(['action' => 'delete_file',$dir]);
                }
                else
                {
					exit;
                    return $this->redirect(['action' => 'index']);
                }
				exit;
            }
			 pr($appNotification); exit;
            $this->Flash->error(__('The AppNotifications could not be saved. Please, try again.'));
        }
		
        $appNotifications = $this->AppNotifications->find()->where(['AppNotifications.city_id'=>$city_id])->order(['AppNotifications.id'=>'DESC']);
		
		
		$categories=$this->AppNotifications->Categories->find('list')->where(['Categories.status'=>'Active','Categories.city_id'=>$city_id]);
		$customers=$this->AppNotifications->AppNotificationCustomers->Customers->find('list')->where(['Customers.city_id'=>$city_id]);
		$Items=$this->AppNotifications->Items->find('list')->where(['Items.status'=>'Active','Items.city_id'=>$city_id]);
		$ComboOffers=$this->AppNotifications->ComboOffers->find('list')->where(['ComboOffers.status'=>'Active','ComboOffers.city_id'=>$city_id]);
		$ItemVariationMaster=$this->AppNotifications->ItemVariations->find()->where(['ItemVariations.status'=>'Active','ItemVariations.city_id'=>$city_id])->contain(['Items','UnitVariations'=>['Units']]);

		foreach($ItemVariationMaster as $data){
			$item_name=$data->item->name;
			$item_id=$data->item->id;
			$category_id=$data->item->category_id;
			$convert_unit_qty=$data->unit_variation->convert_unit_qty;
			$unit_name=$data->unit_variation->unit->unit_name;
			$id=$data->id;
			$show=$item_name.'('.$convert_unit_qty.'-'.$unit_name.')';
			$variation_options[]=['value'=>$id,'text'=>$show, 'category_id'=>$category_id, 'item_id'=>$item_id];
		}
		
		$appNotifications = $this->paginate($appNotifications);
		$paginate_limit=$this->paginate['limit'];
		//pr($appNotifications->toArray());
		$this->set(compact('appNotifications','appNotification','paginate_limit','categories','Items','Sellers','ComboOffers','ItemVariationMasters','variation_options', 'customers'));
		 
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
		$server_path=$this->request->here();
		$server_path='http://13.126.159.20/';
		$user_id=$this->Auth->User('id');
        $city_id=$this->Auth->User('city_id');
        $location_id=$this->Auth->User('location_id'); 
        $state_id=$this->Auth->User('state_id'); 
        $this->viewBuilder()->layout('super_admin_layout');
		$appNotification = $this->AppNotifications->newEntity();
		
        $this->paginate = [
            'contain' => ['Cities'],
			'limit' => 20
        ];
		
		if ($this->request->is(['post','put'])) {
			 
			
			$image_web=$this->request->data['image_web'];
			$send_type=$this->request->data['send_type'];
			@$main_customer_ids=$this->request->data['customer_id'];
			
			$web_image_error=$image_web['error'];
			
            $appNotification = $this->AppNotifications->patchEntity($appNotification, $this->request->getData());
			if(empty($web_image_error))
			{
				$banner_ext=explode('/',$image_web['type']);
				$banner_image_name='AppNotifications'.time().'.'.$banner_ext[1];
			}

			$appNotification->city_id=$city_id;
			//$appNotification->location_id=$location_id;
			$appNotification->location_id=1;
			$appNotification->created_by=$user_id;
			 	//pr($appNotification->toArray()); exit;
				$link_name=$this->request->data['link_name'];
				$category_id=$this->request->data['category_id'];
				$item_id=$this->request->data['item_id'];
				$item_variation_id=$this->request->data['item_variation_id'];
				$combo_offer_id=$this->request->data['combo_offer_id'];
				if($link_name=='product_description'){
					
					$dummy_link='jainthela://'.$link_name.'?id='.$item_id.'&var_id='.$item_variation_id.'&cat_id='.$category_id;
					$dummy_web_link='/Items/'.$link_name.'?id='.$item_id.'&var_id='.$item_variation_id.'&cat_id='.$category_id;
					
				}else if($link_name=='combo_description'){
					
					$dummy_link='jainthela://'.$link_name.'?id='.$combo_offer_id;
					$dummy_web_link='/comboOffers/'.$combo_offer_id;
					
				}else if($link_name=='category_wise'){
					
					$dummy_link='jainthela://'.$link_name.'?id='.$category_id;
					$dummy_web_link='/Categories/'.$category_id;
					
				}else if($link_name=='item_wise'){
					
					$dummy_link='jainthela://'.$link_name.'?id='.$item_id;
					$dummy_web_link='/Items/'.$item_id;
					
				}else if($link_name=='combo'){
					
					$dummy_link='jainthela://'.$link_name.'?id='.$item_id;
					$dummy_web_link='/Items/'.$item_id;
					
				}else if($link_name=='store_item_wise'){
					
					$dummy_link='jainthela://'.$link_name.'?id='.$category_id;
					$dummy_web_link='/Items/'.$category_id;
					
				}else{
					
					$dummy_link='jainthela://'.$link_name;
					$dummy_web_link='/Items/'.$link_name;
				}
				$appNotification->app_link=$dummy_link;
				$appNotification->web_link=$dummy_web_link;
            if ($banner_data=$this->AppNotifications->save($appNotification)) {
			
				if(empty($web_image_error))
				{
					/* For Web Image */
					$deletekeyname = 'AppNotifications/'.$banner_data->id.'/web';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'AppNotifications/'.$banner_data->id.'/web/'.$banner_image_name;
					$this->AwsFile->putObjectFile($keyname,$image_web['tmp_name'],$image_web['type']);
					$banner_data->image_web=$keyname;
					$this->AppNotifications->save($banner_data);

					/* Resize Image */
					$destination_url = WWW_ROOT . 'img/temp/'.$banner_image_name;
					if($banner_ext[1]=='png'){
						$image = imagecreatefrompng($image_web['tmp_name']);
					}else{
						$image = imagecreatefromjpeg($image_web['tmp_name']); 
					}
					$im = imagejpeg($image, $destination_url, 10);
					
					
					/* For App Image */
					$deletekeyname = 'AppNotifications/'.$banner_data->id.'/app';
					$this->AwsFile->deleteMatchingObjects($deletekeyname);
					$keyname = 'AppNotifications/'.$banner_data->id.'/app/'.$banner_image_name;
					$this->AwsFile->putObjectFile($keyname,$image_web['tmp_name'],$image_web['type']);
					$banner_data->image_app=$keyname;
					$this->AppNotifications->save($banner_data);

					$dir  = WWW_ROOT .  'img'.DS.'temp'.DS.$banner_image_name;
                    $dir = $this->EncryptingDecrypting->encryptData($dir);
				}else{
					$keyname='img/jain.png';
				}
				
					$image_result=$this->AwsFile->getObjectFile($keyname);
					$img_url='data:'.$image_result['ContentType'].';base64,'.base64_encode($image_result['Body']);
					
					
					$final_link=$banner_data->app_link;
					if(!empty($final_link)){
						$created_link=$final_link;
					}else{
						$created_link='/jainthela://home';
					}
					
					$message=$banner_data->message;
					$title=$banner_data->title;
					$app_url=$banner_data->app_link;
					$web_url=$banner_data->web_link;
					
					if($send_type=='All'){
					$tokens_data=$this->AppNotifications->AppNotificationTokens->find()->where(['AppNotificationTokens.city_id'=>$city_id]);
					
					foreach($tokens_data as $tkn_data){
						
						$web_token=$tkn_data->web_token;
						$app_token=$tkn_data->app_token;
						
						
						if(($web_token!='NULL')){
							$device_tokens=$web_token;
							define('SERVER_API_KEY','AIzaSyDQcVP0eF_55UrqTxYOAmdeeEzt2lQ6PAg');	
							$main_url=$web_url;
						}
						if(($app_token!='NULL')){
							$device_tokens=$app_token;
							define('SERVER_API_KEY','AAAAXmNqxY4:APA91bG0X6RHVhwJKXUQGNSSCas44hruFdR6_CFd6WHPwx9abUr-WsrfEzsFInJawElgrp24QzaE4ksfmXu6kmIL6JG3yP487fierMys5byv-I1agRtMPIoSqdgCZf8R0iqsnds-u4CU');
							$main_url=$app_url;
						}
						//$device_tokens='fiv6reOde8w:APA91bGqiTQMcu9_U19hqGYOU7EioP4US-uIBDWpFvgSIk02mJc2xxK_Ervmp6BgFHMH3dapxgsnpDFjx7UfjykubJYueoeFAuXya85yMzMhU33IOdQqXjrl51Z-QMW7PoYNc6-VgbNo';
						//$device_tokens="cfroufH_wtc:APA91bFjkWZ0WG_xvcLrtkAG3hheQK0tUipIPufdCYT85UkzhRyL_vEn8nOK--0zTj1w1b6OTcvnv81PhxFe4jgEpyAAwlHZ8MQvJBznCQLIAi4RD30vphR8uiZFWrzZ3SVVnYPjRSla"; 
						 
		if(($web_token!='NULL') || ($app_token!='NULL')){
			
			
	$tokens = array($device_tokens);

	$header = [
		'Content-Type:application/json',
		'Authorization: Key='.SERVER_API_KEY
	];

	$msg = [
		'title'=> $title,
		'body' => $message,
		'message' => $message,
		'icon' => 'img/jain.png',
		'url' => $main_url
	];
	
	$payload = array(
		'registration_ids' => $tokens,
		'data' => $msg
	);
	
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => json_encode($payload),
	  CURLOPT_HTTPHEADER => $header
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	echo "hello1";
	pr($payload);
	$final_result=json_decode($response);
	$sms_flag=$final_result->success; 	
	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  echo $response;
	}			
			   
						 }
					
					}
			}else{ 
					//define('SERVER_API_KEY','AIzaSyDQcVP0eF_55UrqTxYOAmdeeEzt2lQ6PAg');
					foreach($main_customer_ids as $main_custmr_data){
						
						$customers_data=$this->AppNotifications->Customers->find()->where(['Customers.id'=>$main_custmr_data])->first();
						
						$device_token1=$customers_data->fcm_token;
						
						if((!empty($device_token1))){
									
							$main_url=$web_url;
							$device_token=$device_token1;
						}
						 
						 
						 
		if(!empty($device_token1)){
			
			
	$tokens = array($device_token);

	$header = [
		'Content-Type:application/json',
		'Authorization: Key=AIzaSyDQcVP0eF_55UrqTxYOAmdeeEzt2lQ6PAg'
	];

	$msg = [
		'title'=> $title,
		'message' => 'HELLO WORLD'.$message,
		'image' => $server_path.'img/jain.png',
		'link' => $main_url
	];
	
	$payload = array(
		'registration_ids' => $tokens,
		'data' => $msg
	);
	
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => json_encode($payload),
	  CURLOPT_HTTPHEADER => $header
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	pr($payload);
	$final_result=json_decode($response);
	$sms_flag=$final_result->success; 	
	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  echo $response;
	}			
			  
    	 		 
				if($sms_flag>0){
					 	$query = $this->AppNotifications->AppNotificationCustomers->query();
						$query->insert(['app_notification_id', 'customer_id', 'sent'])
								->values([
								'app_notification_id' => $banner_data->id,
								'customer_id' => $main_custmr_data,
								'sent' => $sms_flag
								])
								->execute();
				 }	
						 }
					
					}
					
					
////////////////////////////SECOND/////////////////////////////////
//define('SERVER_API_KEY','AAAAXmNqxY4:APA91bG0X6RHVhwJKXUQGNSSCas44hruFdR6_CFd6WHPwx9abUr-WsrfEzsFInJawElgrp24QzaE4ksfmXu6kmIL6JG3yP487fierMys5byv-I1agRtMPIoSqdgCZf8R0iqsnds-u4CU');
foreach($main_customer_ids as $main_custmr_data){
						
						$customers_data=$this->AppNotifications->Customers->find()->where(['Customers.id'=>$main_custmr_data])->first();
						 
						$main_device_token1=$customers_data->device_token;
						 
						if((!empty($main_device_token1))){
								
							$main_url=$app_url;
							$device_token=$main_device_token1;
						}
						 
						 
		if(!empty($main_device_token1)){
			
			
	$tokens = array($device_token);

	$header = [
		'Content-Type:application/json',
		'Authorization: Key=AAAAXmNqxY4:APA91bG0X6RHVhwJKXUQGNSSCas44hruFdR6_CFd6WHPwx9abUr-WsrfEzsFInJawElgrp24QzaE4ksfmXu6kmIL6JG3yP487fierMys5byv-I1agRtMPIoSqdgCZf8R0iqsnds-u4CU'
	];

	$msg = [
		'title'=> $title,
		'message' => $message,
		'image' => $server_path.'img/jain.png',
		'link' => $main_url
	];
	
	$payload = array(
		'registration_ids' => $tokens,
		'data' => $msg
	);
	
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => json_encode($payload),
	  CURLOPT_HTTPHEADER => $header
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	pr($payload);
	$final_result=json_decode($response);
	$sms_flag=$final_result->success; 	
	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  echo $response;
	}			
			  
    	 		 
				if($sms_flag>0){
					 	$query = $this->AppNotifications->AppNotificationCustomers->query();
						$query->insert(['app_notification_id', 'customer_id', 'sent'])
								->values([
								'app_notification_id' => $banner_data->id,
								'customer_id' => $main_custmr_data,
								'sent' => $sms_flag
								])
								->execute();
				 }	
						 }
					
					}					
////////////////////////////SECOND/////////////////////////////////					
					
			}
				exit; 
                $this->Flash->success(__('The AppNotifications has been saved.'));

                if(empty($web_image_error))
                {
                 return $this->redirect(['action' => 'delete_file',$dir]);
                }
                else
                {
					exit;
                    return $this->redirect(['action' => 'index']);
                }
				exit;
            }
			 pr($appNotification); exit;
            $this->Flash->error(__('The AppNotifications could not be saved. Please, try again.'));
        }
		
        $appNotifications = $this->AppNotifications->find()->where(['AppNotifications.city_id'=>$city_id])->order(['AppNotifications.id'=>'DESC']);
		
		$customers=$this->AppNotifications->AppNotificationCustomers->Customers->find('list')->where(['Customers.city_id'=>$city_id]);
		$categories=$this->AppNotifications->Categories->find('list')->where(['Categories.status'=>'Active','Categories.city_id'=>$city_id]);
		$Items=$this->AppNotifications->Items->find('list')->where(['Items.status'=>'Active','Items.city_id'=>$city_id]);
		$ComboOffers=$this->AppNotifications->ComboOffers->find('list')->where(['ComboOffers.status'=>'Active','ComboOffers.city_id'=>$city_id]);
		$ItemVariationMaster=$this->AppNotifications->ItemVariations->find()->where(['ItemVariations.status'=>'Active','ItemVariations.city_id'=>$city_id])->contain(['Items','UnitVariations'=>['Units']]);
		
		foreach($ItemVariationMaster as $data){
			$item_name=$data->item->name;
			$item_id=$data->item->id;
			$category_id=$data->item->category_id;
			$convert_unit_qty=$data->unit_variation->convert_unit_qty;
			$unit_name=$data->unit_variation->unit->unit_name;
			$id=$data->id;
			$show=$item_name.'('.$convert_unit_qty.'-'.$unit_name.')';
			$variation_options[]=['value'=>$id,'text'=>$show, 'category_id'=>$category_id, 'item_id'=>$item_id];
		}
		
		$appNotifications = $this->paginate($appNotifications);
		$paginate_limit=$this->paginate['limit'];
		//pr($appNotifications->toArray());
		$this->set(compact('appNotifications','appNotification','paginate_limit','categories','Items','Sellers','ComboOffers','ItemVariationMasters','variation_options','customers'));
		 
    }

    /**
     * View method
     *
     * @param string|null $id App Notification id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $appNotification = $this->AppNotifications->get($id, [
            'contain' => ['Cities', 'Locations', 'Items', 'ItemVariations', 'ComboOffers', 'WishLists', 'Categories', 'AppNotificationCustomers']
        ]);

        $this->set('appNotification', $appNotification);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $appNotification = $this->AppNotifications->newEntity();
        if ($this->request->is('post')) {
            $appNotification = $this->AppNotifications->patchEntity($appNotification, $this->request->getData());
            if ($this->AppNotifications->save($appNotification)) {
                $this->Flash->success(__('The app notification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The app notification could not be saved. Please, try again.'));
        }
        $cities = $this->AppNotifications->Cities->find('list', ['limit' => 200]);
        $locations = $this->AppNotifications->Locations->find('list', ['limit' => 200]);
        $items = $this->AppNotifications->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->AppNotifications->ItemVariations->find('list', ['limit' => 200]);
        $comboOffers = $this->AppNotifications->ComboOffers->find('list', ['limit' => 200]);
        $wishLists = $this->AppNotifications->WishLists->find('list', ['limit' => 200]);
        $categories = $this->AppNotifications->Categories->find('list', ['limit' => 200]);
        $this->set(compact('appNotification', 'cities', 'locations', 'items', 'itemVariations', 'comboOffers', 'wishLists', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id App Notification id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $appNotification = $this->AppNotifications->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $appNotification = $this->AppNotifications->patchEntity($appNotification, $this->request->getData());
            if ($this->AppNotifications->save($appNotification)) {
                $this->Flash->success(__('The app notification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The app notification could not be saved. Please, try again.'));
        }
        $cities = $this->AppNotifications->Cities->find('list', ['limit' => 200]);
        $locations = $this->AppNotifications->Locations->find('list', ['limit' => 200]);
        $items = $this->AppNotifications->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->AppNotifications->ItemVariations->find('list', ['limit' => 200]);
        $comboOffers = $this->AppNotifications->ComboOffers->find('list', ['limit' => 200]);
        $wishLists = $this->AppNotifications->WishLists->find('list', ['limit' => 200]);
        $categories = $this->AppNotifications->Categories->find('list', ['limit' => 200]);
        $this->set(compact('appNotification', 'cities', 'locations', 'items', 'itemVariations', 'comboOffers', 'wishLists', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id App Notification id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
	 
	public function deleteFile($dir)
    {
        $dir = $this->EncryptingDecrypting->decryptData($dir);
        $dir  = new File($dir);             
        if ($dir->exists()) 
        {
            $dir->delete(); 
        }
         return $this->redirect(['action' => 'index']);
        exit;
    }
	
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $appNotification = $this->AppNotifications->get($id);
        if ($this->AppNotifications->delete($appNotification)) {
            $this->Flash->success(__('The app notification has been deleted.'));
        } else {
            $this->Flash->error(__('The app notification could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
