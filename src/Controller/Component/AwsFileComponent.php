<?php
namespace App\Controller\Component;
use App\Controller\AppController;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
require_once(ROOT . DS  .'vendor' . DS  .  'autoload.php');
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
class AwsFileComponent extends Component
{
	function initialize(array $config) 
	{
		parent::initialize($config);
		$this->AwsFiles = TableRegistry::get('AwsFiles');
		$AwsFiles=$this->AwsFiles->get(1);
		$this->bucketName=$AwsFiles->bucket_name;  // Bucket Name
		$this->awsAccessKey=$AwsFiles->access_key; // Access Key
		$this->awsSecretAccessKey=$AwsFiles->secret_access_key;  // Secret Access key
	}
	
	/*     Connect to AWS S3   */
	function credential()
	{
		$config = [
					'region'  => 'ap-south-1',
					'version' => 'latest',
					'credentials' => [
						'key'    => $this->awsAccessKey,
						'secret' => $this->awsSecretAccessKey
					],
					'options' => [
					'scheme' => 'http',
					],
					'http'    => [
						'verify' => ROOT . DS  .'vendor' . DS . 'composer' . DS . 'ca-bundle' . DS . 'res' . DS . 'cacert.pem'
					]
				]; 

		$this->s3Client = new S3Client($config);
	}
	
	/*  Store Image on s3             */
	function putObjectFile($keyname,$sourceFile,$contentType)
	{		
		$this->credential();
		$this->s3Client->putObject(array(
			'Bucket' => $this->bucketName,
			'Key'    => $keyname,
			'SourceFile'   => $sourceFile,
			'ContentType'  => $contentType,
			'ContentDisposition' => 'inline',
			'ACL'          => 'public-read',
			'StorageClass' => 'REDUCED_REDUNDANCY'
		));
	}
	
	/*  Store PDF on s3             */
	function putObjectPdf($keyname,$body,$contentType)
	{				
		$this->credential();
		$this->s3Client->putObject(array(
			'Bucket' => $this->bucketName,
			'Key'    => $keyname,
			'Body'   => $body,
			'ContentType'  => $contentType,
			'ContentDisposition' => 'inline',
			'ACL'          => 'public-read',
			'StorageClass' => 'REDUCED_REDUNDANCY'
		));
	}
	
	/*  Store any file on s3             */
	function deleteObjectFile($keyname)
	{		
		$this->credential();
		$s3Client->deleteObject(array(
			'Bucket' => $this->bucketName,
			'Key'    => $keyname
		));
	}
	
	/*  Get object of image/pdf etc. from s3             */
	function getObjectFile($keyname)
	{			
		$this->credential();
		$result = $this->s3Client->getObject(array(
			'Bucket' => $this->bucketName,
			'Key'    => $keyname
		));
		return $result;
	}
	
	/*  File exist or not on s3             */
	function doesObjectExistFile($keyname)
	{
		$this->credential();
		$result = $this->s3Client->doesObjectExist($this->bucketName, $keyname);
		return $result;
	}
}
?>