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
		$working_key='A7a76ea72525fc05bbe9963267b48dd96';
		$sms_sender='JAINTE';
		$sms_send=file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mobile_no.'&text='.$sms_replace.'&route=7');
	}
}
