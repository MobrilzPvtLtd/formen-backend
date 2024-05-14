<?php
require dirname( dirname(__FILE__) ).'/inc/Connection.php';
require dirname( dirname(__FILE__) ).'/inc/Gomeet.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);

if ($data['uid'] == '' or $data['plan_id'] == '' or $data['transaction_id'] == '' or $data['pname'] == '') {
    $returnArr = array(
        "ResponseCode" => "401",
        "Result" => "false",
        "ResponseMsg" => "Something Went Wrong!"
    );
} else {
	$plan_id = $data['plan_id'];
	$transaction_id = $data['transaction_id'];
	$uid = $data['uid'];
	$pname = $data['pname'];
	$p_method_id = $data['p_method_id'];
	$fetch = $dating->query("select * from tbl_plan where id=".$plan_id."")->fetch_assoc();
	
	 $datetime    = date("Y-m-d H:i:s");
	 $current_date = date("Y-m-d");
	 $till_date = date("Y-m-d", strtotime("+ ".$fetch['day_limit']." day"));
	$title = "Plan Purchase Successfully";
	$description = "".$fetch['title']." Plan Purchase From ".$current_date." To ".$till_date.". Payment Gateway Name: ".$pname." Transaction Id: ".$transaction_id."";
	$table        = "tbl_notification";
	$field_values = array(
                    "uid",
                    "datetime",
                    "title",
                    "description"
                );
                $data_values  = array(
                    "$uid",
                    "$datetime",
                    "$title",
                    "$description"
                );
				$h = new Gomeet($dating);
                $check = $h->datinginsertdata_Api($field_values, $data_values, $table);
				
				
	 
	 $titles = $fetch['title'];
	 $amount = $fetch['amt'];
	 $day = $fetch['day_limit'];
	 $plan_description = $fetch['description'];
	 $table        = "plan_purchase_history";
	$field_values = array(
                    "uid",
                    "plan_id",
                    "p_name",
                    "t_date",
					"amount",
					"day",
					"plan_title",
					"plan_description",
					"expire_date",
					"start_date",
					"trans_id",
					"p_method_id"
					
                );
                $data_values  = array(
                    "$uid",
                    "$plan_id",
                    "$pname",
                    "$datetime",
					"$amount",
					"$day",
					"$titles",
					"$plan_description",
					"$till_date",
					"$current_date",
					"$transaction_id",
					"$p_method_id"
                );
				$h = new Gomeet($dating);
                $history_id = $h->datinginsertdata_Api_Id($field_values, $data_values, $table);
				
				
				$table="tbl_user";
  $field = array('plan_start_date'=>$current_date,'plan_end_date'=>$till_date,'plan_id'=>$plan_id,'is_subscribe'=>'1','history_id'=>$history_id);
  $where = "where id=".$uid."";
$h = new Gomeet($dating);
	 $check = $h->datingupdateData_Api($field,$table,$where);
	 
	 
	 $udata = $dating->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
$name = $udata['name'];
$content = array(
       "en" => $name.', Plan Successfully Purchased.'
   );
$heading = array(
   "en" => "Plan Purchased!!"
);

$fields = array(
'app_id' => $set['one_key'],
'included_segments' =>  array("Active Users"),
'filters' => array(array('field' => 'tag', 'key' => 'user_id', 'relation' => '=', 'value' => $uid)),
'contents' => $content,
'headings' => $heading
);

$fields = json_encode($fields);

 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
curl_setopt($ch, CURLOPT_HTTPHEADER, 
array('Content-Type: application/json; charset=utf-8',
'Authorization: Basic '.$set['one_hash']));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
 
$response = curl_exec($ch);
curl_close($ch);

	$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Plan Purchase Successfully!");
	}
echo json_encode($returnArr);
?>