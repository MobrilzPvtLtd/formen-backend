<?php
require dirname(dirname(__FILE__)) . '/../inc/Connection.php';

$senderId = $_GET['sender_id'];
$receiverId = $_GET['receiver_id'];

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

$row = $checkChatResult->fetch_assoc();
$chatId = $row['id'];

// Fetch messages from the database based on the chat_id
$sql = "SELECT * FROM messages WHERE chat_id = '$chatId' ORDER BY timestamp ASC";
$result = $dating->query($sql);

$response = array('status' => 'success', 'chat' => $row);
header('Content-Type: application/json');
echo json_encode($response);
?>