<?php
require dirname(dirname(__FILE__)) . '/inc/Connection.php';
require dirname(dirname(__FILE__)) . '/inc/Gomeet.php';
$data = json_decode(file_get_contents('php://input'), true);
header('Content-type: text/json');
$uid = $data['uid'];


if ($uid == '') {
    $returnArr = array("ResponseCode" => "401", "Result" => "false", "ResponseMsg" => "Something Went wrong  try again !");
} else {
    $CurrentTime = date("Y-m-d H:i:s");

    $check = $dating->query("UPDATE `tbl_user` SET `last_available` = $CurrentTime WHERE `tbl_user`.`id` = $uid");

    $returnArr = array("ResponseCode" => "200", "Result" => "true", "ResponseMsg" => "Last Available Updated Successfully!!!");

}
echo json_encode($returnArr);
?>