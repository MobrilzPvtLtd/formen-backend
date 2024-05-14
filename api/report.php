<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
require dirname( dirname(__FILE__) ).'/inc/Gomeet.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
if($data['uid'] == '' or $data['reporter_id'] == '' or $data['comment'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    
    $uid = strip_tags(mysqli_real_escape_string($dating,$data['uid']));
    $reporter_id = strip_tags(mysqli_real_escape_string($dating,$data['reporter_id']));
    $comment = strip_tags(mysqli_real_escape_string($dating,$data['comment']));
    $report_date = date("Y-m-d H:i:s");
	
	$table="report";
  $field_values=array("uid","reporter_id","comment","report_date");
  $data_values=array("$uid","$reporter_id","$comment","$report_date");
  
   $h = new Gomeet($dating);
	  $check = $h->datinginsertdata_Api($field_values,$data_values,$table);
	  
	  $returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Report Done Successfully!");
}
echo json_encode($returnArr);
?>
    