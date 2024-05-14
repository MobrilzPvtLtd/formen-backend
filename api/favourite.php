<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
$uid = $data['uid'];
$lats = $data['lats'];
$longs = $data['longs'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function calculateDistance($originLat, $originLng, $destLat, $destLng, $apiKey) {
    $unit = "K";
    $theta = (float)$originLng - (float)$destLng;
    $dist = sin(deg2rad((float)$originLat)) * sin(deg2rad((float)$destLat)) + cos(deg2rad((float)$originLat)) * cos(deg2rad((float)$destLat)) * cos(deg2rad((float)$theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        $distanceInKilometers = $miles * 1.609344;
        return round($distanceInKilometers, 2); // Rounded to 2 decimal places
    } else if ($unit == "N") {
        $distanceInNauticalMiles = $miles * 0.8684;
        return round($distanceInNauticalMiles, 2); // Rounded to 2 decimal places
    } else {
        return round($miles, 2); // Rounded to 2 decimal places
    }
}


function calculateMatchRatio($userProfile, $otherProfile) {
    $userAttributes = array(
        'relation_goal' => [$userProfile['relation_goal']],
        'interest' => explode(',', $userProfile['interest']),
        'language' => explode(',', $userProfile['language']),
        'religion' => [$userProfile['religion']]
    );

    $otherAttributes = array(
        'relation_goal' => [$otherProfile['relation_goal']],
        'interest' => explode(',', $otherProfile['interest']),
        'language' => explode(',', $otherProfile['language']),
        'religion' => [$otherProfile['religion']]
    );

    $totalAttributes = 0;
    $matchingAttributes = 0;

    foreach ($userAttributes as $key => $value) {
        $totalAttributes += count(array_unique(array_merge($value, $otherAttributes[$key])));
        $matchingAttributes += count(array_intersect($value, $otherAttributes[$key]));
    }

    if ($totalAttributes == 0) {
        return 0;  // Prevent division by zero
    }

    $matchRatio = ($matchingAttributes / $totalAttributes) * 100;
	$matchRatio = min($matchRatio, 100);
    return round($matchRatio, 2);
}


if ($uid =='' or $lats =='' or $longs =='')
{	
$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went wrong  try again !");
}
else 
{
$getdata = $dating->query("SELECT * FROM tbl_user WHERE id = ".$uid."")->fetch_assoc();
$getlike = $dating->query("SELECT * FROM `tbl_action` where uid=".$uid." and action='LIKE' and action != 'block'");
$kl = array();
$user = array();
while($rp = $getlike->fetch_assoc())
{
	$checklike = $dating->query("SELECT * FROM `tbl_action` where uid=".$rp['profile_id']." and profile_id=".$uid." and action='LIKE'")->num_rows;
	if($checklike != 0)
	{
	
	$userdata = $dating->query("select * from tbl_user where id=".$rp['profile_id']."")->fetch_assoc();	
	$actions = $dating->query("SELECT * from tbl_action where action='BLOCK' and profile_id=".$rp['profile_id']."")->num_rows;
	if($actions != 0)
	{
	}
	else 
	{	
	$birthdateObj = new DateTime($userdata['birth_date']);
$currentDateObj = new DateTime();

// Calculate the difference between the two dates
$ageInterval = $birthdateObj->diff($currentDateObj);
	$matchRatio = calculateMatchRatio($getdata, $userdata);
	$kl['profile_id'] = $userdata['id'];
	$kl['profile_name'] = $userdata['name'];
	$kl['is_verify'] = $userdata['is_verify'];
	$kl['profile_bio'] = $userdata['profile_bio'];
	$kl['profile_age'] = $ageInterval->y;
	$distance = calculateDistance($lats, $longs,$userdata['lats'], $userdata['longs'], $apiKey);
	$kl['profile_distance'] = $distance.' KM';
	$kl['profile_images'] = explode('$;',$userdata['other_pic']);
	$kl['match_ratio'] = $matchRatio;
    $user[] =  $kl;	
	}
	}
}
$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Home Data Get Successfully!!!","favlist"=>$user);	
	
}
echo json_encode($returnArr);