<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';

header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
$pol = array();
$c = array();
$sel = $dating->query("select * from relation_goal where status=1");
while($row = $sel->fetch_assoc())
{
   
		$pol['id'] = $row['id'];
		$pol['title'] = $row['title'];
		
		$pol['subtitle'] = $row['subtitle'];
		
		
		$c[] = $pol;
	
	
}
if(empty($c))
{
	$returnArr = array("goallist"=>$c,"ResponseCode"=>"200","Result"=>"false","ResponseMsg"=>"Relation Goal Not Founded!");
}
else 
{
$returnArr = array("goallist"=>$c,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Relation Goal List Founded!");
}
echo json_encode($returnArr);
?>