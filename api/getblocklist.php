<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
require dirname( dirname(__FILE__) ).'/inc/Gomeet.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
if($data['uid'] == '')
{
 $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");    
}
else
{
	$uid = $data['uid'];
	$blo = $dating->query("select profile_id from tbl_action where uid=".$uid." and action='BLOCK'");
	$pol = array();
	while($p = $blo->fetch_assoc())
	{
		$pol[] = $p['profile_id'];
	}
	
	$blos = $dating->query("select uid from tbl_action where profile_id=".$uid." and action='BLOCK'");
	$pols = array();
	while($ps = $blos->fetch_assoc())
	{
		$pols[] = $ps['uid'];
	}
	
	$returnArr = array("block_by_me"=>$pol,"block_by_other"=>$pols,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Block Id List Founded!");
}
echo  json_encode($returnArr);
?>