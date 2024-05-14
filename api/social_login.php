<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
$data = json_decode(file_get_contents('php://input'), true);
header('Content-type: text/json');
if($data['email'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    $email = strip_tags(mysqli_real_escape_string($dating,$data['email']));
    
$chek = $dating->query("select * from tbl_user where email='".$email."'");

if($chek->num_rows != 0)
{
	$status = $dating->query("select * from tbl_user where status = 1 and  email='".$email."'");
if($status->num_rows !=0)
{
    $c = $dating->query("select * from tbl_user where  email='".$email."'");
    $c = $c->fetch_assoc();
	
    $returnArr = array("UserLogin"=>$c,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Login successfully!");
	}
else  
{
	 $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Your profile has been blocked by the administrator, preventing you from using our app as a regular user.");
}
}
else
{
    $returnArr = array("ResponseCode"=>"201","Result"=>"false","ResponseMsg"=>"Account Not Found!!");
}

}

echo json_encode($returnArr);