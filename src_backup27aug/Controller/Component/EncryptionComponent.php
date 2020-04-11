<?php
namespace App\Controller\Component;
use App\Controller\AppController;
use Cake\Controller\Component;

class EncryptionComponent extends Component
{
	function initialize(array $config) 
	{
		parent::initialize($config);
	}

	function encrypt($string) {
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$secret_key = '55f4b5c32611b87c';
		$secret_iv = 'd0a7e7997b6d5fcd';
		// hash
		$key = hash('sha256', $secret_key);
		
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($output);
		return $output;
	}	
	function decrypt($string) {
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$secret_key = '55f4b5c32611b87c';
		$secret_iv = 'd0a7e7997b6d5fcd';
		// hash
		$key = hash('sha256', $secret_key);
		
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		return $output;
	}	
	
	
	
	
/* 	public function encrypt($encrypt){
		$keys='d0a7e7997b6d5fcd55f4b5c32611b87c';
        $encrypt = serialize($encrypt);
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
        $key = pack('H*', $keys);
        $mac = hash_hmac('sha256', $encrypt, substr($keys, -32));
        $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt . $mac, MCRYPT_MODE_CBC, $iv);
        $encoded = base64_encode($passcrypt) . '|' . base64_encode($iv);
        return $encoded;
    }

    public function decrypt($decrypt){
		$keys='d0a7e7997b6d5fcd55f4b5c32611b87c';
        $decrypt = explode('|', $decrypt.'|');
        $decoded = base64_decode($decrypt[0]);
        $iv = base64_decode($decrypt[1]);
        if(strlen($iv)!==mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)){ return false; }
        $key = pack('H*', $keys);
        $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
        $mac = substr($decrypted, -64);
        $decrypted = substr($decrypted, 0, -64);
        $calcmac = hash_hmac('sha256', $decrypted, substr($keys, -32));
        if($calcmac !== $mac){
            return false;
        }
        $decrypted = unserialize($decrypted);
        return $decrypted;
    } */


}
?>