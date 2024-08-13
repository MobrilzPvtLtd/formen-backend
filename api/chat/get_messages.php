<?php
require dirname(dirname(__FILE__)) . '/../inc/Connection.php';

$senderId = $_GET['sender_id'];
$receiverId = $_GET['receiver_id'];

// Sanitize input ...

// Check if a chat exists between these users
$checkChatSql = "SELECT id FROM chats WHERE (user1_id = '$senderId' AND user2_id = '$receiverId') OR (user1_id = '$receiverId' AND user2_id = '$senderId')";
$checkChatResult = $dating->query($checkChatSql);

if ($checkChatResult->num_rows == 0) {
    // If no chat exists, return an empty response
    $response = array('status' => 'success', 'messages' => array());
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

$row = $checkChatResult->fetch_assoc();
$chatId = $row['id'];

// Fetch messages from the database based on the chat_id
$sql = "SELECT * FROM messages WHERE chat_id = '$chatId' ORDER BY timestamp ASC";
$result = $dating->query($sql);

$messages = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $message = array(
            'sender_id' => $row["sender_id"],
            'message' => $row["message"]
        );
        $messages[] = $message;
    }
}

$response = array('status' => 'success', 'messages' => $messages);
header('Content-Type: application/json');
echo json_encode($response);
?>