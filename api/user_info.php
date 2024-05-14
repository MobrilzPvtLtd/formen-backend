<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
$uid = $data['uid']; 
if ($uid =='')
{	
$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went wrong  try again !");
}
else 
{
$getplan = $dating->query("SELECT * from tbl_user where id=".$uid."")->fetch_assoc();
$plan_id = $getplan['plan_id'];
$is_subscribe = $getplan['is_subscribe'];
$planinfo = $dating->query("SELECT * from tbl_plan where id=".$plan_id."")->fetch_assoc();
$direct_chat = empty($planinfo['direct_chat']) ? "0" : $planinfo['direct_chat'];
$Like_menu = empty($planinfo['Like_menu']) ? "0" : $planinfo['Like_menu'];
$audio_video = empty($planinfo['audio_video']) ? "0" : $planinfo['audio_video'];
$filter_include = empty($planinfo['filter_include']) ? "0" : $planinfo['filter_include'];
$plan_name = empty($planinfo['title'])	? "FREE" : $planinfo['title'];
$plan_description = empty($planinfo['description'])	? "" : $planinfo['description'];
$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Home Data Get Successfully!!!","direct_chat"=>$direct_chat,"Like_menu"=>$Like_menu,"audio_video"=>$audio_video,"filter_include"=>$filter_include,"plan_name"=>$plan_name,"plan_id"=>$plan_id,"plan_description"=>$plan_description,'is_subscribe'=>$is_subscribe);
}
echo json_encode($returnArr);
?>