<?php 
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
$uid = $data['uid'];
$lats = $data['lats'];
$longs = $data['longs'];
$radius_search = $data['radius_search'];
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
$getprofileid = $dating->query("SELECT GROUP_CONCAT(profile_id) AS pro_id FROM tbl_action WHERE uid = $uid")->fetch_assoc();
if(empty($getprofileid['pro_id']))
{
$id = $uid;	
}
else 
{
	$id = $uid.','.$getprofileid['pro_id'];
}
$search_preference = $data['search_preference'];
$radius_search = $data['radius_search'];
$minage = $data['minage'];
$maxage = $data['maxage'];
$interest = $data['interest'];
$language = $data['language'];
$relation_goal = $data['relation_goal'];
$is_verify = $data['is_verify'];
$religion = $data['religion'];
$interestValues = explode(',', $interest);
$languageValues = explode(',', $language);
$conditions = [];

foreach ($interestValues as $value) {
    $conditions[] = "FIND_IN_SET('$value', tbl_user.interest) > 0";
}

$interestCondition = implode(' AND ', $conditions);

$sqlf = " AND ('$interest' = '0' OR ('$interest' != '0' AND ($interestCondition)))";


$lconditions = [];

foreach ($languageValues as $values) {
    $lconditions[] = "FIND_IN_SET('$values', tbl_user.language) > 0";
}

$languageCondition = implode(' AND ', $lconditions);

$sqll = "AND ('$language' = '0' OR ('$language' != '0' AND ($languageCondition)))";


	$query = "SELECT tbl_user.*
FROM tbl_user
WHERE tbl_user.id NOT IN(".$id.")";

if ($search_preference == 'MALE') {
    $query .= " AND tbl_user.search_preference = 'MALE'";
} elseif ($search_preference == 'FEMALE') {
    $query .= " AND tbl_user.search_preference = 'FEMALE'";
}

if($relation_goal != 0)
{
	$query .= " AND tbl_user.search_preference = ".$relation_goal."";
}

if($religion != 0)
{
	$query .= " AND tbl_user.religion = ".$religion."";
}
if($is_verify != 0)
{
	$query .= " AND tbl_user.is_verify = ".$is_verify."";
}
$query .= $sqlf;
$query .= $sqll;
$query .= " AND birth_date BETWEEN DATE_SUB(CURDATE(), INTERVAL ".$maxage." YEAR) AND DATE_SUB(CURDATE(), INTERVAL ".$minage." YEAR) AND (((acos(sin((".$lats."*pi()/180)) * sin((`lats`*pi()/180)) +
        cos((".$lats."*pi()/180)) * cos((`lats`*pi()/180)) *
        cos(((".$longs."-`longs`)*pi()/180))))*180/pi())*60*1.1515*1.609344) <= ".$radius_search;

    // Use the $query variable in your database query execution.
    $otherprofile = $dating->query($query);
    // Fetch data from $result as needed.

$user = array();
$n = array();
while ($row = $otherprofile->fetch_assoc()) {
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
	$n['profile_lat'] = $row['lats'];
	$n['profile_longs'] = $row['longs'];
	$distance = calculateDistance($lats, $longs,$row['lats'], $row['longs'], $apiKey);
	$n['profile_distance'] = $distance.' KM';
	$n['profile_images'] = explode('$;',$row['other_pic']);
	$n['match_ratio'] = $matchRatio;
    $user[] =  $n;
}

	
$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Filter  Data Get Successfully!!!","profilelist"=>$user);	
}
echo json_encode($returnArr);