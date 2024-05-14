<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
require dirname( dirname(__FILE__) ).'/inc/Gomeet.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
if($data['uid'] == '' || $data['profile_id'] == '')
{
 $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");    
}
else
{
 $uid = $data['uid'];
$profile_id = $data['profile_id']; 
   $table = "tbl_action";

            $where = "where uid=" . $uid . " and profile_id=".$profile_id." and action='BLOCK'";

            $h = new Gomeet($dating);
           
            $check = $h->datingDeleteData_Api($where,$table);
 $returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Unblock Profile Successfully!!");

}
echo  json_encode($returnArr);
?>