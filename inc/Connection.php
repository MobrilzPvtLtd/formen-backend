<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
  $dating = new mysqli("localhost", "ultimm7k_formen", "Ur^WKvkU!1k2", "ultimm7k_formen");
  $dating->set_charset("utf8mb4"); 
} catch(Exception $e) {
  error_log($e->getMessage());
  //Should be a message a typical user could understand
}
$prints = $dating->query("select * from tbl_meet")->fetch_assoc();	
    $set = $dating->query("SELECT * FROM `tbl_setting`")->fetch_assoc();
    $apiKey = "AIzaSyAMAubn-RPNtqBD-4JTq-YkeVi5Fq-MeBc";
?>