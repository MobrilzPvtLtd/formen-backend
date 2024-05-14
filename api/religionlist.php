<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';

header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
$pol = array();
$c = array();
$sel = $dating->query("select * from tbl_religion where status=1");
while($row = $sel->fetch_assoc())
{
   
		$pol['id'] = $row['id'];
		$pol['title'] = $row['title'];
		
		
		
		
		$c[] = $pol;
	
	
}
if(empty($c))
{
	$returnArr = array("religionlist"=>$c,"ResponseCode"=>"200","Result"=>"false","ResponseMsg"=>"Religion Not Founded!");
}
else 
{
$returnArr = array("religionlist"=>$c,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Religion List Founded!");
}
echo json_encode($returnArr);
?>