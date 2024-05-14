<?php
require dirname(dirname(__FILE__)) . '/inc/Connection.php';
require dirname(dirname(__FILE__)) . '/inc/Gomeet.php';
$data = json_decode(file_get_contents('php://input'), true);
header('Content-type: text/json');
$uid = $data['uid'];
$profile_id = $data['profile_id'];
if($uid == '' || $profile_id == '')
{
	$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went wrong  try again !");
}
else 
{
 

     $check = $dating->query("select * from tbl_action where uid=".$uid." and profile_id=".$profile_id." and action='BLOCK'")->num_rows;
	 if($check != 0)
	 {
		 $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Profile BLOCK Already!");
	 }
	 else 
	 {
	 $table="tbl_action";
  $field_values=array("uid","profile_id","action");
  $data_values=array("$uid","$profile_id","BLOCK");
  $h = new Gomeet($dating);
  $check = $h->datinginsertdata_Api($field_values,$data_values,$table);
   $returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Profile BLOCK Successfully!!!");
	 }
}
echo json_encode($returnArr);
?>