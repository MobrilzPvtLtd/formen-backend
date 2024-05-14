<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
require dirname( dirname(__FILE__) ).'/inc/Gomeet.php';
header('Content-type: text/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define('BASE_PATH', dirname(dirname(__FILE__)));
define('IMAGE_PATH', '/images/other_pic/');
function generate_random()
{
	require dirname( dirname(__FILE__) ).'/inc/Connection.php';
	$six_digit_random_number = mt_rand(100000, 999999);
	$c_refer = $dating->query("select * from tbl_user where code=".$six_digit_random_number."")->num_rows;
	if($c_refer != 0)
	{
		generate_random();
	}
	else 
	{
		return $six_digit_random_number;
	}
}

function processFileUploads($prefix, $count, $url) {
    $targetPath = BASE_PATH . $url;
    $uploadedFiles = [];

    for ($i = 0; $i < $count; $i++) {
        $newName = uniqid() . date('YmdHis') . mt_rand() . '.jpg';
        $fileUrl = $url . $newName;

        // Remove leading '/' from each file URL
        $fileUrl = ltrim($fileUrl, '/');

        $uploadedFiles[] = $fileUrl;

        // Move uploaded file and check for errors
        if (!move_uploaded_file($_FILES[$prefix . $i]['tmp_name'], $targetPath . $newName)) {
            // Handle upload error here (e.g., provide feedback to the user)
        }
    }

    return $uploadedFiles;
}


if($_POST['name'] == '' or $_POST['email'] == '' or $_POST['mobile'] == ''   or $_POST['password'] == '' or $_POST['ccode'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    
    $fname = strip_tags(mysqli_real_escape_string($dating,$_POST['name']));
    $email = strip_tags(mysqli_real_escape_string($dating,$_POST['email']));
    $mobile = strip_tags(mysqli_real_escape_string($dating,$_POST['mobile']));
	$ccode = strip_tags(mysqli_real_escape_string($dating,$_POST['ccode']));
	$birth_date = strip_tags(mysqli_real_escape_string($dating,$_POST['birth_date']));
	$search_preference = strip_tags(mysqli_real_escape_string($dating,$_POST['search_preference']));
	$radius_search = strip_tags(mysqli_real_escape_string($dating,$_POST['radius_search']));
	$relation_goal = strip_tags(mysqli_real_escape_string($dating,$_POST['relation_goal']));
	$profile_bio = strip_tags(mysqli_real_escape_string($dating,$_POST['profile_bio']));
	$interest = $_POST['interest'];
	
	$language = $_POST['language'];
    $password = strip_tags(mysqli_real_escape_string($dating,$_POST['password']));
    $refercode = strip_tags(mysqli_real_escape_string($dating,$_POST['refercode']));
	$gender = strip_tags(mysqli_real_escape_string($dating,$_POST['gender']));
	$lats = $_POST['lats'];
	$longs = $_POST['longs'];
	$religion = $_POST['religion'];
	$size = isset($_POST['size']) ? (int) $_POST['size'] : 0;
    $checkmob = $dating->query("select * from tbl_user where mobile=".$mobile."");
    $checkemail = $dating->query("select * from tbl_user where email='".$email."'");
   
   
    if($checkmob->num_rows != 0)
    {
        $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Mobile Number Already Used!");
    }
     else if($checkemail->num_rows != 0)
    {
        $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Email Address Already Used!");
    }
    else
    {
        if($refercode != '')
	   {
		 $c_refer = $dating->query("select * from tbl_user where code=".$refercode."")->num_rows;
		 if($c_refer != 0)
		 {
			 
        
        $prentcode = generate_random();
		$wallet = $dating->query("select * from tbl_setting")->fetch_assoc();
		$fin = $wallet['scredit'];
        $timestamp = date("Y-m-d H:i:s");
        if ($size > 0) {
        // Process single file uploads
        $uploadedFiles = processFileUploads('otherpic', $size, IMAGE_PATH);
        $multifile = implode('$;', $uploadedFiles);
    }
		$table="tbl_user";
  $field_values=array("name","email","mobile","rdate","password","ccode","refercode","wallet","code","gender","lats","longs","birth_date","search_preference","radius_search","relation_goal","interest","language","religion","other_pic","profile_bio");
  $_POST_values=array("$fname","$email","$mobile","$timestamp","$password","$ccode","$refercode","$fin","$prentcode","$gender","$lats","$longs","$birth_date","$search_preference","$radius_search","$relation_goal","$interest","$language","$religion","$multifile","$profile_bio");
		
  
      $h = new Gomeet($dating);
	  $check = $h->datinginsertdata_Api_Id($field_values,$_POST_values,$table);
	  $timestamps    = date("Y-m-d");
 $table="wallet_report";
  $field_values=array("uid","message","status","amt","tdate");
  $_POST_values=array("$check",'Sign up Credit Added!!','Credit',"$fin","$timestamps");
   
      $h = new Gomeet($dating);
	  $checks = $h->datinginsertdata_Api($field_values,$_POST_values,$table);
	  
 $c = $dating->query("select * from tbl_user where id=".$check."")->fetch_assoc();
    
        $returnArr = array("UserLogin"=>$c,"currency"=>$set['currency'],"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Sign Up Done Successfully!");
    }
	else 
		 {
		$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Refer Code Not Found Please Try Again!!");
	   }
	   }
	    else 
	   {
		   $timestamp = date("Y-m-d H:i:s");
		   $prentcode = generate_random();
		   if ($size > 0) {
        // Process single file uploads
        $uploadedFiles = processFileUploads('otherpic', $size, IMAGE_PATH);
        $multifile = implode('$;', $uploadedFiles);
    }
	
		   $table="tbl_user";
  $field_values=array("name","mobile","rdate","password","ccode","code","email","gender","lats","longs","birth_date","search_preference","radius_search","relation_goal","interest","language","religion","other_pic","profile_bio");
  $_POST_values=array("$fname","$mobile","$timestamp","$password","$ccode","$prentcode","$email","$gender","$lats","$longs","$birth_date","$search_preference","$radius_search","$relation_goal","$interest","$language","$religion","$multifile","$profile_bio");
		
   $h = new Gomeet($dating);
	  $check = $h->datinginsertdata_Api_Id($field_values,$_POST_values,$table);
  $c = $dating->query("select * from tbl_user where id=".$check."")->fetch_assoc();
  $returnArr = array("UserLogin"=>$c,"currency"=>$set['currency'],"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Sign Up Done Successfully!");
  
	   }
	}
    
    
}

echo json_encode($returnArr);