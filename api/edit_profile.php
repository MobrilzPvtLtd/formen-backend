<?php
require dirname(dirname(__FILE__)) . '/inc/Connection.php';
require dirname(dirname(__FILE__)) . '/inc/Gomeet.php';
header('Content-type: text/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define('BASE_PATH', dirname(dirname(__FILE__)));
define('IMAGE_PATH', '/images/other_pic/');

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

if ($_POST['name'] == '' or $_POST['email'] == '' or $_POST['mobile'] == '' or $_POST['password'] == '' or $_POST['ccode'] == '') {
    $returnArr = ["ResponseCode" => "401", "Result" => "false", "ResponseMsg" => "Something Went Wrong!"];
} else {
    $name = strip_tags(mysqli_real_escape_string($dating, $_POST['name']));
    $email = strip_tags(mysqli_real_escape_string($dating, $_POST['email']));
    $mobile = strip_tags(mysqli_real_escape_string($dating, $_POST['mobile']));
    $ccode = strip_tags(mysqli_real_escape_string($dating, $_POST['ccode']));
    $birth_date = strip_tags(mysqli_real_escape_string($dating, $_POST['birth_date']));
    $search_preference = strip_tags(mysqli_real_escape_string($dating, $_POST['search_preference']));
    $radius_search = strip_tags(mysqli_real_escape_string($dating, $_POST['radius_search']));
    $relation_goal = strip_tags(mysqli_real_escape_string($dating, $_POST['relation_goal']));
    $profile_bio = strip_tags(mysqli_real_escape_string($dating, $_POST['profile_bio']));
    $interest = $_POST['interest'];
	$height = $_POST['height'];
    $language = $_POST['language'];
    $password = strip_tags(mysqli_real_escape_string($dating, $_POST['password']));
    $gender = strip_tags(mysqli_real_escape_string($dating, $_POST['gender']));
    $lats = $_POST['lats'];
    $longs = $_POST['longs'];
    $religion = $_POST['religion'];
    $uid = $_POST['uid'];
    $imlist = $_POST['imlist'];
    $size = isset($_POST['size']) ? (int) $_POST['size'] : 0;
    $checkmob = $dating->query("select * from tbl_user where mobile=" . $mobile . " and id!=" . $uid . "");
    $checkemail = $dating->query("select * from tbl_user where email='" . $email . "' and id!=" . $uid . "");

    if ($checkmob->num_rows != 0) {
        $returnArr = ["ResponseCode" => "401", "Result" => "false", "ResponseMsg" => "Mobile Number Already Used!"];
    } elseif ($checkemail->num_rows != 0) {
        $returnArr = ["ResponseCode" => "401", "Result" => "false", "ResponseMsg" => "Email Address Already Used!"];
    } else {
        if ($size > 0) {
            // Process single file uploads
            $uploadedFiles = processFileUploads('otherpic', $size, IMAGE_PATH);
            $multifile = implode('$;', $uploadedFiles);
        }

        $imageList = '';
        if (empty($_FILES['otherpic0']['name'][0]) && $imlist != "0") {
            // No new image was uploaded, and there are existing images
            $imageList = $imlist;
        } elseif (empty($_FILES['otherpic0']['name'][0]) && $imlist == "0") {
            // No new image was uploaded, and there are no existing images
            $imageList = $imlist;
        } elseif ($imlist == "0") {
            // New images were uploaded, and there are no existing images
            $imageList = $multifile;
        } else {
            // New images were uploaded, and there are existing images
            $imageList = $imlist . '$;' . $multifile;
        }

        $table = "tbl_user";
        $field = [
            'name' => $name,
            'password' => $password,
            'email' => $email,
            'mobile' => $mobile,
            'ccode' => $ccode,
            'gender' => $gender,
            'lats' => $lats,
            'longs' => $longs,
            'birth_date' => $birth_date,
            'search_preference' => $search_preference,
            'radius_search' => $radius_search,
            'relation_goal' => $relation_goal,
            'interest' => $interest,
            'language' => $language,
            'religion' => $religion,
            'other_pic' => $imageList,
            'profile_bio' => $profile_bio,
			'height'=>$height
        ];
        $where = "where id=" . $uid . "";
        $h = new Gomeet($dating);
        $check = $h->datingupdateData_Api($field, $table, $where);
		$c = $dating->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
  $returnArr = array("UserLogin"=>$c,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Profile Update Successfully!");
    }
}
echo json_encode($returnArr);
