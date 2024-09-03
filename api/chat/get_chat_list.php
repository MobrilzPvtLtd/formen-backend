<?php
require dirname(dirname(__FILE__)) . '/../inc/Connection.php';

$senderId = $_GET['sender_id'];

// Sanitize input ...

// Check if a chat exists between these users
$checkChatSql = "SELECT * FROM chats WHERE (user1_id = '$senderId' OR user2_id = '$senderId')";
$checkChatResult = $dating->query($checkChatSql);

if ($checkChatResult->num_rows == 0) {
    // If no chat exists, return an empty response
    $response = array('status' => 'success', 'chat' => array());
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}




$chats = array();
if ($checkChatResult->num_rows > 0) {
    while ($row = $checkChatResult->fetch_assoc()) {

        // Check for the other user in the chat

        if ($row["user1_id"] == $senderId) {
            $otherUserId = $row["user2_id"];
        } else {
            $otherUserId = $row["user1_id"];
        }

        echo $otherUserId;
        die();

        // Fetch the other user's details

        $OtheruserSql = "SELECT * FROM tbl_user WHERE id = '$otherUserId'";

        $OtheruserResult = $dating->query($OtheruserSql);

        $OtheruserRow = $OtheruserResult->fetch_assoc();

        $chat = array(
            'id' => $row["id"],
            'user1_id' => $row["user1_id"],
            'user2_id' => $row["user2_id"],
            'other_user_name' => $OtheruserRow["name"],
            'other_user_image' => $OtheruserRow["identity_picture"],
            'timestamp' => $row["timestamp"]
        );
        $chats[] = $chat;
    }
}


$response = array('status' => 'success', 'chats' => $chats);
header('Content-Type: application/json');
echo json_encode($response);
?>