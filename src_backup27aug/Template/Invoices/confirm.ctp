<?php 
$pdf_url=$this->Url->build(['controller'=>'Orders','action'=>'pdf']);
$list_url=$this->Url->build(['controller'=>'Orders','action'=>'index']);
//$id1 =$id;


$id = $EncryptingDecrypting->encryptData($ids);
//$id = $EncryptingDecrypting->encryptData($id);
//pr($pdf_url); exit;
//pr($id); exit;
?>
<table width="100%">
	<tr>
		<td valign="top" style="background: #FFF; position:fixed; width: 272px;" >
		<div >
			<a href="<?php echo $list_url; ?>" class="list-group-item"><i class="fa fa-chevron-left"></i> Back to Invoices </a>
			
			<a href="#" class="list-group-item" onclick="window.close()"><i class="fa fa-times"></i> Close </a>
		</div>
		
		</td>
		<td width="80%" style="vertical-align: top;">
			<object data="<?php echo $pdf_url.'/'.$id; ?>" type="application/pdf" width="100%" height="613px">ergregre
			  <p>Wait a while, PDf is loading...</p>
			</object>
		</td>
	</tr>
</table>

