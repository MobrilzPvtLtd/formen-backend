<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
$uid = $data['uid'];
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


if ($uid =='' or $lats =='' or $longs =='')
{	
$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went wrong  try again !");
}
else 
{
$getdata = $dating->query("SELECT * FROM tbl_user WHERE id = ".$uid."")->fetch_assoc();
$action = $dating->query("SELECT GROUP_CONCAT(uid) as liked_profile_id from tbl_action where action='LIKE' and action != 'block' and profile_id=".$uid."")->fetch_assoc();
if (!empty($action['liked_profile_id'])) {
    $query = "SELECT * from tbl_user where id IN(".$action['liked_profile_id'].")";

    // Use the $query variable in your database query execution.
    $otherprofile = $dating->query($query);
    // Fetch data from $result as needed.
$user = array();
$n = array();
while ($row = $otherprofile->fetch_assoc()) {
	
	$checklike = $dating->query("SELECT * FROM `tbl_action` where profile_id=".$row['id']." and uid=".$uid." and (action='LIKE' OR action='UNLIKE') and action != 'block'")->num_rows;
	if($checklike != 0)
	{
	}
	else 
	{
		$actions = $dating->query("SELECT * from tbl_action where action='BLOCK' and profile_id=".$row['id']."")->num_rows;
	if($actions != 0)
	{
	}
	else 
	{	
	$birthdateObj = new DateTime($row['birth_date']);
$currentDateObj = new DateTime();

// Calculate the difference between the two dates
$ageInterval = $birthdateObj->diff($currentDateObj);

    $matchRatio = calculateMatchRatio($getdata, $row);
	$n['profile_id'] = $row['id'];
	
	$n['profile_name'] = $row['name'];
	$n['profile_bio'] = $row['profile_bio'];
	$n['is_verify'] = $row['is_verify'];
	$n['profile_age'] = $ageInterval->y;
	$distance = calculateDistance($lats, $longs,$row['lats'], $row['longs'], $apiKey);
	$n['profile_distance'] = $distance.' KM';
	$n['profile_images'] = explode('$;',$row['other_pic']);
	$n['match_ratio'] = $matchRatio;
    $user[] =  $n;
	}
	}
}

	
$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Home Data Get Successfully!!!","likemelist"=>$user);
} else {
    
    $returnArr = array("ResponseCode" => "401", "Result" => "false", "ResponseMsg" => "No liked profiles found");
    
}	
}
echo json_encode($returnArr);