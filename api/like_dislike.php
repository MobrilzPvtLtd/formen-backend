<?php
require dirname(dirname(__FILE__)) . '/inc/Connection.php';
require dirname(dirname(__FILE__)) . '/inc/Gomeet.php';
$data = json_decode(file_get_contents('php://input'), true);
header('Content-type: text/json');
$uid = $data['uid'];
$profile_id = $data['profile_id'];
$action = $data['action'];
if($uid == '' || $profile_id == '' || $action == '')
{
	$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went wrong  try again !");
}
else 
{
 $check = $dating->query("select * from tbl_action where uid=".$uid." and profile_id=".$profile_id."")->num_rows;
 if($check != 0)
 {
	$table="tbl_action";
  $field = array('action'=>$action);
  $where = "where uid=".$uid." and profile_id=".$profile_id."";
$h = new Gomeet($dating);
	  $check = $h->datingupdateData_Api($field,$table,$where);
	  
      $returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Profile Action Update Successfully !!");
	  
 }
 else 
 {
     
	 $table="tbl_action";
  $field_values=array("uid","profile_id","action");
  $data_values=array("$uid","$profile_id","$action");
  $h = new Gomeet($dating);
  $check = $h->datinginsertdata_Api($field_values,$data_values,$table);
   $returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Like Successfully!!!");
   
    
	$udata = $dating->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
$name = $udata['name'];
$content = array(
       "en" => $name.', Someone Liked You.'
   );
$heading = array(
   "en" => "Like Profile!!"
);

$fields = array(
'app_id' => $set['one_key'],
'included_segments' =>  array("Active Users"),
'filters' => array(array('field' => 'tag', 'key' => 'user_id', 'relation' => '=', 'value' => $profile_id)),
'contents' => $content,
'headings' => $heading
);

$fields = json_encode($fields);

 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
curl_setopt($ch, CURLOPT_HTTPHEADER, 
array('Content-Type: application/json; charset=utf-8',
'Authorization: Basic '.$set['one_hash']));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
 
$response = curl_exec($ch);
curl_close($ch);

 }
}
echo json_encode($returnArr);
?>