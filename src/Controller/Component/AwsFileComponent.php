<?php
namespace App\Controller\Component;
use App\Controller\AppController;
use Cake\Controller\Component;
require_once(ROOT . DS  .'vendor' . DS  .  'autoload.php');
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
class AwsFileComponent extends Component
{
    function credential($awsAccessKey,$awsSecretAccessKey)
	{ 
		$config = [
					'region'  => 'ap-south-1',
					'version' => 'latest',
					'credentials' => [
						'key'    => $awsAccessKey,
						'secret' => $awsSecretAccessKey
					],
					'options' => [
					'scheme' => 'http',
					],
					'http'    => [
						'verify' => ROOT . DS  .'vendor' . DS . 'composer' . DS . 'ca-bundle' . DS . 'res' . DS . 'cacert.pem'
					]
				]; 

		return $s3Client = new S3Client($config);
	}
	function putObjectFile($s3Client,$bucketName,$keyname,$sourceFile,$contentType)
	{				
		$s3Client->putObject(array(
			'Bucket' => $bucketName,
			'Key'    => $keyname,
			'SourceFile'   => $sourceFile,
			'ContentType'  => $contentType,
			'ContentDisposition' => 'inline',
			'ACL'          => 'public-read',
			'StorageClass' => 'REDUCED_REDUNDANCY'
		));
	}
	function putObjectPdf($s3Client,$bucketName,$keyname,$body,$contentType)
	{				
		$s3Client->putObject(array(
			'Bucket' => $bucketName,
			'Key'    => $keyname,
			'Body'   => $body,
			'ContentType'  => $contentType,
			'ContentDisposition' => 'inline',
			'ACL'          => 'public-read',
			'StorageClass' => 'REDUCED_REDUNDANCY'
		));
	}
	function deleteObjectFile($s3Client,$bucketName,$keyname)
	{				
		$s3Client->deleteObject(array(
			'Bucket' => $bucketName,
			'Key'    => $keyname
		));
	}
	function getObjectFile($s3Client,$bucketName,$keyname)
	{				
		 $result = $s3Client->getObject(array(
			'Bucket' => $bucketName,
			'Key'    => $keyname
		));
		return $result;
	}
	function doesObjectExistFile($s3Client,$bucketName,$keyname)
	{
		$result = $s3Client->doesObjectExist($bucketName, $keyname);
		return $result;
	}
}
?>