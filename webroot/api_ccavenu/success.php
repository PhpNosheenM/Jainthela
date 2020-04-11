<?php 
	include('Crypto.php');
	error_reporting(0);
	$workingKey='0138CFCDE02CFF53882E19CF60A53C5A';		//Working Key should be provided here.
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$ccavvenue_order_no="";
	$tracking_id="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	
	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		if($i==3)	
        $order_status=$information[1];
		if($information[0] == 'tracking_id') { $tracking_id = $information[1]; }
	}

	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		$o_id=$information['order_id'];
	
	}
	if(!empty($order_status))
	{
		echo "<script> processHTML(); </script>";	
	}
?>
	<input type="hidden" name="order_status" id="order_status" value="<?php echo $order_status; ?>" />
	<input type="hidden" name="tracking_id" id="tracking_id" value="<?php echo $tracking_id; ?>" />
	<script>
	function processHTML() {
		var order_status = document.getElementById("order_status").value;
		var ccavvenue_tracking_no = document.getElementById("tracking_id").value;
		window.HTMLOUT.processHTMLResponse(order_status,ccavvenue_tracking_no);
  	}
	</script>	

	
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 50px;
  height: 50px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
</head>
<body>
<center>
<h3>Trasaction is in progress. Please wait...</h3>
<p style="color:red;">Please do not close this page while you trasaction is being confirmed</p>
<p>This page will refresh shortly.</p>
<div class="loader"></div>
</center>
</body>
</html>
		
	
	
	