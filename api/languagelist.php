<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';

header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
$pol = array();
$c = array();
$sel = $dating->query("select * from tbl_language where status=1");
while($row = $sel->fetch_assoc())
{
   
		$pol['id'] = $row['id'];
		$pol['title'] = $row['title'];
		
		$pol['img'] = $row['img'];
		
		
		$c[] = $pol;
	
	
}
if(empty($c))
{
	$returnArr = array("languagelist"=>$c,"ResponseCode"=>"200","Result"=>"false","ResponseMsg"=>"Language Not Founded!");
}
else 
{
$returnArr = array("languagelist"=>$c,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Language List Founded!");
}
echo json_encode($returnArr);
?>