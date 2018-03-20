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

     }
     private $iv = 'd0a7e7997b6d5fcd';
     private $key = '55f4b5c32611b87c';
// reference URL for encription : https://github.com/serpro/Android-PHP-Encrypt-Decrypt/blob/master/PHP/MCrypt.php
  function encrypt($str, $isBinary = false)
     {
         $iv = $this->iv;
         $str = $isBinary ? $str : utf8_decode($str);
         $td = mcrypt_module_open('rijndael-128', ' ', 'cbc', $iv);
         mcrypt_generic_init($td, $this->key, $iv);
         $encrypted = mcrypt_generic($td, $str);
         mcrypt_generic_deinit($td);
         mcrypt_module_close($td);
         return $isBinary ? $encrypted : bin2hex($encrypted);
     }

     function decrypt($code, $isBinary = false)
     {
         $code = $isBinary ? $code : $this->hex2bin($code);
         $iv = $this->iv;
         $td = mcrypt_module_open('rijndael-128', ' ', 'cbc', $iv);
         mcrypt_generic_init($td, $this->key, $iv);
         $decrypted = mdecrypt_generic($td, $code);
         mcrypt_generic_deinit($td);
         mcrypt_module_close($td);
         return $isBinary ? trim($decrypted) : utf8_encode(trim($decrypted));
     }
     protected function hex2bin($hexdata)
     {
         $bindata = '';
         for ($i = 0; $i < strlen($hexdata); $i += 2) {
             $bindata .= chr(hexdec(substr($hexdata, $i, 2)));
         }
         return $bindata;
     }

     public function awsData()
     {
         $this->AwsFiles = TableRegistry::get('AwsFiles');
         $AwsFiles=$this->AwsFiles->get(1);
         $this->bucketName=$AwsFiles->bucket_name;  // Bucket Name
         $this->awsAccessKey=$AwsFiles->access_key; // Access Key
         $this->awsSecretAccessKey=$AwsFiles->secret_access_key;  // Secret Access key

         $awsData = array("bucketName"=>$this->encrypt($this->bucketName),
                    "awsAccessKey"=>$this->encrypt($this->awsAccessKey),
                    "awsSecretAccessKey"=>$this->encrypt($this->awsSecretAccessKey));
          if(!empty($awsData))
          {
              $success = true;
              $message = 'Data Found Successfully';
          } else {
            $success = true;
            $message = 'Data Not Found';
          }
          //pr($this->decrypt($awsData['bucketName'])); exit;
         $this->set(['success' => $success,'message'=>$message,'awsData' => $awsData,'_serialize' => ['success','message','awsData']]);
   }


}
