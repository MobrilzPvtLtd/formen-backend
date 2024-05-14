<?php
require "Connection.php";
require "Gomeet.php";

if (isset($_POST["type"])) {
    if ($_POST['type'] == 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $h = new Gomeet($dating);

        $count = $h->datinglogin($username, $password, 'admin');
        if($count == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
        if ($count == 1) {
            $_SESSION['carname'] = $username;

            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Login Successfully!", "message" => "welcome admin!!", "action" => "dashboard.php"];
        } else {
            $returnArr = ["ResponseCode" => "200", "Result" => "false", "title" => "Please Use Valid Data!!", "message" => "welcome admin!!", "action" => "index.php"];
        }
        }
    }
    elseif($_POST["type"] == "add_plan")
	{
		$title = $dating->real_escape_string($_POST["title"]);
		$amt = $_POST['amt'];
		$day_limit = $_POST["day_limit"];
		$description = $dating->real_escape_string($_POST["description"]);
		$filter_include = empty($_POST["filter_include"]) ? 0 : 1;
		$audio_video = empty($_POST["audio_video"]) ? 0 : 1;
		$direct_chat = empty($_POST["direct_chat"]) ? 0 : 1;
		$chat = empty($_POST["chat"]) ? 0 : 1;
		$Like_menu = empty($_POST["Like_menu"]) ? 0 : 1;
		$status = $_POST["status"];
		
		$table = "tbl_plan";
            $field_values = [
                "title",
                "amt",
                "day_limit",
                "description",
                "filter_include",
                "audio_video",
                "direct_chat",
                "chat",
                "Like_menu",
				"status"
            ];
            $data_values = [
                "$title",
                "$amt",
                "$day_limit",
                "$description",
                "$filter_include",
                "$audio_video",
                "$direct_chat",
                "$chat",
                "$Like_menu",
				"$status"
            ];

            $h = new Gomeet($dating);
            $check = $h->datinginsertdata($field_values, $data_values, $table);
			if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Plan Add Successfully!!",
                    "message" => "Plan section!",
                    "action" => "list_plan.php",
                ];
            } 
		}
	}		
	elseif($_POST["type"] == "edit_plan")
	{
		$title = $dating->real_escape_string($_POST["title"]);
		$amt = $_POST['amt'];
		$day_limit = $_POST["day_limit"];
		$description = $dating->real_escape_string($_POST["description"]);
		$filter_include = empty($_POST["filter_include"]) ? 0 : 1;
		$audio_video = empty($_POST["audio_video"]) ? 0 : 1;
		$direct_chat = empty($_POST["direct_chat"]) ? 0 : 1;
		$chat = empty($_POST["chat"]) ? 0 : 1;
		$Like_menu = empty($_POST["Like_menu"]) ? 0 : 1;
		$status = $_POST["status"];
		$id = $_POST["id"];
		
		$table = "tbl_plan";
                $field = ["status" => $status, "title" => $title,"amt"=>$amt,"day_limit"=>$day_limit,"description"=>$description,"filter_include"=>$filter_include,"audio_video"=>$audio_video,"direct_chat"=>$direct_chat,"chat"=>$chat,"Like_menu"=>$Like_menu];
                $where = "where id=" . $id . "";
                $h = new Gomeet($dating);
                $check = $h->datingupdateData($field, $table, $where);
if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
                if ($check == 1) {
                    $returnArr = [
                        "ResponseCode" => "200",
                        "Result" => "true",
                        "title" => "Plan Update Successfully!!",
                        "message" => "Plan section!",
                        "action" => "list_plan.php",
                    ];
                } 
		}
	}
	
      elseif ($_POST['type'] == 'add_page') {
        $ctitle = $dating->real_escape_string($_POST['ctitle']);
        $cstatus = $_POST['cstatus'];
        $cdesc = $dating->real_escape_string($_POST['cdesc']);
        $table = "tbl_page";

        $field_values = ["description", "status", "title"];
        $data_values = ["$cdesc", "$cstatus", "$ctitle"];

        $h = new Gomeet($dating);
        $check = $h->datinginsertdata($field_values, $data_values, $table);
		if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
        if ($check == 1) {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Page Add Successfully!!", "message" => "Page section!", "action" => "list_page.php"];
        } 
		}
    } elseif ($_POST['type'] == 'edit_page') {
        $id = $_POST['id'];
        $ctitle = $dating->real_escape_string($_POST['ctitle']);
        $cstatus = $_POST['cstatus'];
        $cdesc = $dating->real_escape_string($_POST['cdesc']);

        $table = "tbl_page";
        $field = ['description' => $cdesc, 'status' => $cstatus, 'title' => $ctitle];
        $where = "where id=" . $id . "";
        $h = new Gomeet($dating);
        $check = $h->datingupdateData($field, $table, $where);
		if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
        if ($check == 1) {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Page Update Successfully!!", "message" => "Page section!", "action" => "list_page.php"];
        } 
		}
    } elseif ($_POST['type'] == 'edit_payment') {
        $attributes = mysqli_real_escape_string($dating, $_POST['p_attr']);
        $ptitle = mysqli_real_escape_string($dating, $_POST['ptitle']);
        $okey = $_POST['status'];
        $id = $_POST['id'];
        $p_show = $_POST['p_show'];
        $target_dir = dirname(dirname(__FILE__)) . "/images/payment/";
        $url = "images/payment/";
        $temp = explode(".", $_FILES["cat_img"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        if ($_FILES["cat_img"]["name"] != '') {
            
                move_uploaded_file($_FILES["cat_img"]["tmp_name"], $target_file);
                $table = "tbl_payment_list";
                $field = ['status' => $okey, 'img' => $url, 'attributes' => $attributes, 'subtitle' => $ptitle, 'p_show' => $p_show];
                $where = "where id=" . $id . "";
                $h = new Gomeet($dating);
                $check = $h->datingupdateData($field, $table, $where);
if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
                if ($check == 1) {
                    $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Payment Gateway Update Successfully!!", "message" => "Payment Gateway section!", "action" => "paymentlist.php"];
                } 
		}
        } else {
            $table = "tbl_payment_list";
            $field = ['status' => $okey, 'attributes' => $attributes, 'subtitle' => $ptitle, 'p_show' => $p_show];
            $where = "where id=" . $id . "";
            $h = new Gomeet($dating);
            $check = $h->datingupdateData($field, $table, $where);
			if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Payment Gateway Update Successfully!!", "message" => "Payment Gateway section!", "action" => "paymentlist.php"];
            } 
		}
        }
    } elseif ($_POST['type'] == 'add_faq') {
        $question = mysqli_real_escape_string($dating, $_POST['question']);
        $answer = mysqli_real_escape_string($dating, $_POST['answer']);
        $okey = $_POST['status'];

        $table = "tbl_faq";
        $field_values = ["question", "answer", "status"];
        $data_values = ["$question", "$answer", "$okey"];

        $h = new Gomeet($dating);
        $check = $h->datinginsertdata($field_values, $data_values, $table);
		if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
        if ($check == 1) {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Faq Add Successfully!!", "message" => "Faq section!", "action" => "list_faq.php"];
        } 
		}
    } elseif ($_POST['type'] == 'edit_faq') {
        $question = mysqli_real_escape_string($dating, $_POST['question']);
        $answer = mysqli_real_escape_string($dating, $_POST['answer']);
        $okey = $_POST['status'];
        $id = $_POST['id'];

        $table = "tbl_faq";
        $field = ['question' => $question, 'status' => $okey, 'answer' => $answer];
        $where = "where id=" . $id . "";
        $h = new Gomeet($dating);
        $check = $h->datingupdateData($field, $table, $where);
		if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
        if ($check == 1) {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Faq Update Successfully!!", "message" => "Faq section!", "action" => "list_faq.php"];
        }
		}		
    }  elseif ($_POST['type'] == 'edit_profile') {
        
            $dname = $_POST['username'];
            $dsname = $_POST['password'];
            $id = $_POST['id'];
            $table = "admin";
            $field = ['username' => $dname, 'password' => $dsname];
            $where = "where id=" . $id . "";
            $h = new Gomeet($dating);
            $check = $h->datingupdateData($field, $table, $where);
			if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Profile Update Successfully!!", "message" => "Profile  section!", "action" => "profile.php"];
            } 
        }
    }  elseif ($_POST['type'] == 'edit_setting') {
        $webname = mysqli_real_escape_string($dating, $_POST['webname']);
        $timezone = $_POST['timezone'];
        $currency = $_POST['currency'];
        $id = $_POST['id'];
        
        
        $one_key = $_POST['one_key'];
        $one_hash = $_POST['one_hash'];

       

        $target_dir = dirname(dirname(__FILE__)) . "/images/website/";
        $url = "images/website/";
        $temp = explode(".", $_FILES["weblogo"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        if ($_FILES["weblogo"]["name"] != '') {
            
                move_uploaded_file($_FILES["weblogo"]["tmp_name"], $target_file);
                $table = "tbl_setting";
                $field = ['timezone' => $timezone, 'weblogo' => $url, 'webname' => $webname, 'currency' => $currency, 'one_key' => $one_key, 'one_hash' => $one_hash];
                $where = "where id=" . $id . "";
                $h = new Gomeet($dating);
                $check = $h->datingupdateData($field, $table, $where);
if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
                if ($check == 1) {
                    $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Setting Update Successfully!!", "message" => "Setting section!", "action" => "setting.php"];
                } 
		}
        } else {
            $table = "tbl_setting";
            $field = ['timezone' => $timezone, 'webname' => $webname, 'currency' => $currency, 'one_key' => $one_key, 'one_hash' => $one_hash];
            $where = "where id=" . $id . "";
            $h = new Gomeet($dating);
            $check = $h->datingupdateData($field, $table, $where);
			if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Setting Update Successfully!!", "message" => "Offer section!", "action" => "setting.php"];
            } 
		}
        }
    }  elseif ($_POST["type"] == "add_interest") {
        $okey = $_POST["status"];
        $title = $dating->real_escape_string($_POST["cat_name"]);
        $target_dir = dirname(dirname(__FILE__)) . "/images/interest/";
        $url = "images/interest/";
        $temp = explode(".", $_FILES["cat_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        
            move_uploaded_file($_FILES["cat_img"]["tmp_name"], $target_file);
            $table = "tbl_interest";
            $field_values = ["img", "status","title"];
            $data_values = ["$url", "$okey", "$title"];

            $h = new Gomeet($dating);
            $check = $h->datinginsertdata($field_values, $data_values, $table);
			if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Interest Add Successfully!!",
                    "message" => "Interest section!",
                    "action" => "list_interest.php",
                ];
            } 
		}
        
    }elseif ($_POST["type"] == "add_language") {
        $okey = $_POST["status"];
        $title = $dating->real_escape_string($_POST["cat_name"]);
        $target_dir = dirname(dirname(__FILE__)) . "/images/language/";
        $url = "images/language/";
        $temp = explode(".", $_FILES["cat_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        
            move_uploaded_file($_FILES["cat_img"]["tmp_name"], $target_file);
            $table = "tbl_language";
            $field_values = ["img", "status","title"];
            $data_values = ["$url", "$okey", "$title"];

            $h = new Gomeet($dating);
            $check = $h->datinginsertdata($field_values, $data_values, $table);
			if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Language Add Successfully!!",
                    "message" => "Language section!",
                    "action" => "list_language.php",
                ];
            } 
		}
        
    }elseif ($_POST["type"] == "add_religion") {
        $okey = $_POST["status"];
        $title = $dating->real_escape_string($_POST["cat_name"]);

            $table = "tbl_religion";
            $field_values = [ "status","title"];
            $data_values = ["$okey", "$title"];

            $h = new Gomeet($dating);
            $check = $h->datinginsertdata($field_values, $data_values, $table);
			if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Religion Add Successfully!!",
                    "message" => "Religion section!",
                    "action" => "list_religion.php",
                ];
            } 
        }
    } elseif ($_POST["type"] == "add_relation") {
        $okey = $_POST["status"];
        $title = $dating->real_escape_string($_POST["title"]);
		$subtitle = $dating->real_escape_string($_POST["subtitle"]);

            $table = "relation_goal";
            $field_values = [ "status","title","subtitle"];
            $data_values = ["$okey", "$title", "$subtitle"];

            $h = new Gomeet($dating);
            $check = $h->datinginsertdata($field_values, $data_values, $table);
			if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Relation Goal Add Successfully!!",
                    "message" => "Relation Goal section!",
                    "action" => "list_goal.php",
                ];
            } 
        }
    } elseif ($_POST["type"] == "edit_interest") {
        $okey = $_POST["status"];
        $id = $_POST["id"];
		$title = $dating->real_escape_string($_POST['cat_name']);
        $target_dir = dirname(dirname(__FILE__)) . "/images/interest/";
        $url = "images/interest/";
        $temp = explode(".", $_FILES["cat_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        if ($_FILES["cat_img"]["name"] != "") {
            
                move_uploaded_file($_FILES["cat_img"]["tmp_name"], $target_file);
                $table = "tbl_interest";
                $field = ["status" => $okey, "img" => $url,"title"=>$title];
                $where = "where id=" . $id . "";
                $h = new Gomeet($dating);
                $check = $h->datingupdateData($field, $table, $where);
if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
                if ($check == 1) {
                    $returnArr = [
                        "ResponseCode" => "200",
                        "Result" => "true",
                        "title" => "Interest Update Successfully!!",
                        "message" => "Interest section!",
                        "action" => "list_interest.php",
                    ];
                } 
		}
        } else {
            $table = "tbl_interest";
            $field = ["status" => $okey,"title"=>$title];
            $where = "where id=" . $id . "";
            $h = new Gomeet($dating);
            $check = $h->datingupdateData($field, $table, $where);
			if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Interest Update Successfully!!",
                    "message" => "Interest section!",
                    "action" => "list_interest.php",
                ];
            } 
		}
        }
    } elseif ($_POST["type"] == "edit_language") {
        $okey = $_POST["status"];
        $id = $_POST["id"];
		$title = $dating->real_escape_string($_POST['cat_name']);
        $target_dir = dirname(dirname(__FILE__)) . "/images/language/";
        $url = "images/language/";
        $temp = explode(".", $_FILES["cat_img"]["name"]);
        $newfilename = round(microtime(true)) . "." . end($temp);
        $target_file = $target_dir . basename($newfilename);
        $url = $url . basename($newfilename);
        if ($_FILES["cat_img"]["name"] != "") {
            
                move_uploaded_file($_FILES["cat_img"]["tmp_name"], $target_file);
                $table = "tbl_language";
                $field = ["status" => $okey, "img" => $url,"title"=>$title];
                $where = "where id=" . $id . "";
                $h = new Gomeet($dating);
                $check = $h->datingupdateData($field, $table, $where);
if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
                if ($check == 1) {
                    $returnArr = [
                        "ResponseCode" => "200",
                        "Result" => "true",
                        "title" => "Interest Update Successfully!!",
                        "message" => "Interest section!",
                        "action" => "list_language.php",
                    ];
                } 
		} 
        } else {
            $table = "tbl_language";
            $field = ["status" => $okey,"title"=>$title];
            $where = "where id=" . $id . "";
            $h = new Gomeet($dating);
            $check = $h->datingupdateData($field, $table, $where);
			if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Interest Update Successfully!!",
                    "message" => "Interest section!",
                    "action" => "list_language.php",
                ];
            } 
		}
        }
    }elseif ($_POST["type"] == "edit_religion") {
        $okey = $_POST["status"];
        $id = $_POST["id"];
		$title = $dating->real_escape_string($_POST['cat_name']);
      
            $table = "tbl_religion";
            $field = ["status" => $okey,"title"=>$title];
            $where = "where id=" . $id . "";
            $h = new Gomeet($dating);
            $check = $h->datingupdateData($field, $table, $where);
			if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Religion Update Successfully!!",
                    "message" => "Religion section!",
                    "action" => "list_religion.php",
                ];
            } 
        }
    }elseif ($_POST["type"] == "edit_relation") {
        $okey = $_POST["status"];
        $id = $_POST["id"];
		$title = $dating->real_escape_string($_POST['title']);
		$subtitle = $dating->real_escape_string($_POST['subtitle']);
      
            $table = "relation_goal";
            $field = ["status" => $okey,"title"=>$title,"subtitle"=>$subtitle];
            $where = "where id=" . $id . "";
            $h = new Gomeet($dating);
            $check = $h->datingupdateData($field, $table, $where);
			if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Relation Goal Update Successfully!!",
                    "message" => "Relation Goal section!",
                    "action" => "list_goal.php",
                ];
            } 
        }
    } 	elseif ($_POST["type"] == "update_status") {
        $id = $_POST["id"];
        $status = $_POST["status"];
        $coll_type = $_POST["coll_type"];
        $page_name = $_POST["page_name"];
         if ($coll_type == "userstatus") {
            $table = "tbl_user";
            $field = "status=" . $status . "";
            $where = "where id=" . $id . "";
            $h = new Gomeet($dating);
            $check = $h->datingupdateData_single($field, $table, $where);
			if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "User Status Change Successfully!!",
                    "message" => "User section!",
                    "action" => "userlist.php",
                ];
            } 
		}
        }elseif ($coll_type == "verifystatus") {
			if($status == 0)
			{
             $table = "tbl_user";
            $field = ["is_verify" => $status,"identity_picture"=>NULL,"is_verify"=>0];
            $where = "where id=" . $id . "";
            $h = new Gomeet($dating);
            $check = $h->datingupdateData($field, $table, $where);
			}
			else 
			{
            $table = "tbl_user";
            $field = "is_verify=" . $status . "";
            $where = "where id=" . $id . "";
            $h = new Gomeet($dating);
            $check = $h->datingupdateData_single($field, $table, $where);
			}
			if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "User Verify Change Successfully!!",
                    "message" => "User section!",
                    "action" => "userlist.php",
                ];
            } 
		}
        }  elseif ($coll_type == "dark_mode") {
		
            $table = "tbl_setting";
            $field = "show_dark=" . $status . "";
            $where = "where id=" . $id . "";
            $h = new Gomeet($dating);
            $check = $h->datingupdateData_single($field, $table, $where);
			if($check == -1)
        {
            $returnArr = ["ResponseCode" => "200", "Result" => "true", "title" => "Please Activate Domain First!!!", "message" => "Validation!!", "action" => "validate_domain.php"];
        }
        else 
        {
            if ($check == 1) {
                $returnArr = [
                    "ResponseCode" => "200",
                    "Result" => "true",
                    "title" => "Dark Mode Status Change Successfully!!",
                    "message" => "Dark Mode section!",
                    "action" => $page_name,
                ];
            } 
		}
        }
		

		else {
            $returnArr = [
                "ResponseCode" => "200",
                "Result" => "false",
                "title" => "Option Not There!!",
                "message" => "Error!!",
                "action" => "dashboard.php",
            ];
        }
    } else {
        $returnArr = ["ResponseCode" => "200", "Result" => "false", "title" => "Don't Try Extra Function!", "message" => "welcome admin!!", "action" => "dashboard.php"];
    }
} else {
    $returnArr = ["ResponseCode" => "200", "Result" => "false", "title" => "Don't Try Extra Function!", "message" => "welcome admin!!", "action" => "dashboard.php"];
}
echo json_encode($returnArr);
?>
