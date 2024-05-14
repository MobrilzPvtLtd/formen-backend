<?php 
require dirname(dirname(__FILE__)) . '/inc/Connection.php';
require dirname(dirname(__FILE__)) . '/inc/Gomeet.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);

if($data['uid'] == '' or $data['img'] == '')
{
 $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");    
}
else
{
 $uid =  $dating->real_escape_string($data['uid']);
 $img = $data['img'];
 $img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$path = 'images/profile/'.uniqid().'.png';
$fname = dirname( dirname(__FILE__) ).'/'.$path;

file_put_contents($fname, $data);
 
 $table="tbl_user";
  $field = array('identity_picture'=>$path,'is_verify'=>1);
  $where = "where id=".$uid."";
  $h = new Gomeet($dating);
	  $check = $h->datingupdateData_Api($field,$table,$where);
	  $c = $dating->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
 $returnArr = array("UserLogin"=>$c,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Identity Document Upload Successfully!!");
}
echo  json_encode($returnArr);
?>