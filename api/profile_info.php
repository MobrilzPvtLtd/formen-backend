<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
$uid = $data['uid'];
$profile_id = $data['profile_id'];
$lats = $data['lats'];
$longs = $data['longs'];


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


if ($uid =='' or $lats =='' or $longs =='' or $profile_id == '')
{	
$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went wrong  try again !");
}
else 
{
$getdata = $dating->query("SELECT * FROM tbl_user WHERE id = ".$uid."")->fetch_assoc();
$otherprofile = $dating->query("SELECT * FROM tbl_user WHERE id = ".$profile_id."")->fetch_assoc();

$user = array();
$n = array();

	$birthdateObj = new DateTime($otherprofile['birth_date']);
$currentDateObj = new DateTime();

// Calculate the difference between the two dates
$ageInterval = $birthdateObj->diff($currentDateObj);

    $matchRatio = calculateMatchRatio($getdata, $otherprofile);
	$n['profile_id'] = $otherprofile['id'];
	$n['profile_name'] = $otherprofile['name'];
	$n['profile_bio'] = $otherprofile['profile_bio'];
	$n['profile_age'] = $ageInterval->y;
	$distance = calculateDistance($lats, $longs,$otherprofile['lats'], $otherprofile['longs'], $apiKey);
	$n['profile_distance'] = $distance.' KM';
	$n['profile_images'] = explode('$;',$otherprofile['other_pic']);
	$n['match_ratio'] = $matchRatio;
	$n['is_verify'] = $otherprofile['is_verify'];
	$n['height'] = $otherprofile['height'];
	$rgoal = $dating->query("select * from relation_goal where id=".$otherprofile['relation_goal']."")->fetch_assoc();
	$n['relation_title'] = $rgoal['title'];
	$n['relation_subtitle'] = $rgoal['subtitle'];
    $reli = $dating->query("select * from tbl_religion where id=".$otherprofile['religion']."")->fetch_assoc();
	$n['religion_title'] = $reli['title'];
	$in = array();
	$inte = $dating->query("select title,img from tbl_interest where id IN(".$otherprofile['interest'].")");
	while($row = $inte->fetch_assoc())
	{
		$in[] = $row;
	}
	$n['interest_list'] = $in;
	$lan = array();
	$lang = $dating->query("select title,img from tbl_language where id IN(".$otherprofile['language'].")");
	while($rows = $lang->fetch_assoc())
	{
		$lan[] = $rows;
	}
	$n['language_list'] = $lan;


	
$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Profile Information Get Successfully!!!","profileinfo"=>$n);	
}
echo json_encode($returnArr);