<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Cake\ORM\TableRegistry;

class AwsFilesController extends AppController
{
    public function initialize()
     {
         parent::initialize();
         $this->Auth->allow(['awsData']);
         define('ENCRYPTION_KEY', 'd0a7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca282');
     }

// reference URL for encription : https://www.warpconduit.net/2013/04/14/highly-secure-data-encryption-decryption-made-easy-with-php-mcrypt-rijndael-256-and-cbc/
     function mc_encrypt($encrypt, $key){
      $encrypt = serialize($encrypt);
      $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
      $key = pack('H*', $key);
      $mac = hash_hmac('sha256', $encrypt, substr(bin2hex($key), -32));
      $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt.$mac, MCRYPT_MODE_CBC, $iv);
      $encoded = base64_encode($passcrypt).'|'.base64_encode($iv);
      return $encoded;
  }

  function mc_decrypt($decrypt, $key){
      $decrypt = explode('|', $decrypt.'|');
      $decoded = base64_decode($decrypt[0]);
      $iv = base64_decode($decrypt[1]);
      if(strlen($iv)!==mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)){ return false; }
      $key = pack('H*', $key);
      $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
      $mac = substr($decrypted, -64);
      $decrypted = substr($decrypted, 0, -64);
      $calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
      if($calcmac!==$mac){ return false; }
      $decrypted = unserialize($decrypted);
      return $decrypted;
  }


     public function awsData()
     {
         $this->AwsFiles = TableRegistry::get('AwsFiles');
         $AwsFiles=$this->AwsFiles->get(1);
         $this->bucketName=$AwsFiles->bucket_name;  // Bucket Name
         $this->awsAccessKey=$AwsFiles->access_key; // Access Key
         $this->awsSecretAccessKey=$AwsFiles->secret_access_key;  // Secret Access key

         $awsData = array("bucketName"=>$this->mc_encrypt($this->bucketName,ENCRYPTION_KEY),
                    "awsAccessKey"=>$this->mc_encrypt($this->awsAccessKey,ENCRYPTION_KEY),
                    "awsSecretAccessKey"=>$this->mc_encrypt($this->awsSecretAccessKey,ENCRYPTION_KEY));

          if(!empty($awsData))
          {
              $success = true;
              $message = 'Data Found Successfully';
          } else {
            $success = true;
            $message = 'Data Not Found';
          }

          //pr($this->mc_decrypt($age['bucketName'],ENCRYPTION_KEY)); exit;

         $this->set(['success' => $success,'message'=>$message,'awsData' => $awsData,'_serialize' => ['success','message','awsData']]);
   }


}
