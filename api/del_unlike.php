<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
require dirname( dirname(__FILE__) ).'/inc/Gomeet.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
if($data['uid'] == '')
{
 $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");    
}
else
{
 $uid = $data['uid'];  
   $table = "tbl_action";


            $where = "where uid=" . $uid . " and action='UNLIKE'";

            $h = new Gomeet($dating);
           
            $check = $h->datingDeleteData_Api($where,$table);
 $returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Recover Successfully!!");

}
echo  json_encode($returnArr);
?>