<?php
namespace App\Controller\Component;
use App\Controller\AppController;
use Cake\Controller\Component;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
class SmsComponent extends Component
{
	function sendSms($mobile_no=null,$content=null){
		
		$sms = $content;
		$sms_replace=str_replace(" ", '+', $sms);
		$sms_send=file_get_contents('https://control.msg91.com/api/sendhttp.php?authkey=165796AYmYc8YcTY59783a05&mobiles='.$mobile_no.'&message='.$sms_replace.'&sender=EHIRES&route=4&country=91');
	}
}