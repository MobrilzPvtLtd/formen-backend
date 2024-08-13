<?php
// Database connection (replace with your actual credentials)
require dirname(dirname(__FILE__)) . '/../inc/Connection.php';

$ResResult = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chatId = $_POST['chat_id'];
    $senderId = $_POST['sender_id'];
    $receiverId = $_POST['receiver_id'];
    $message = $_POST['message'];

    // Sanitize input (use appropriate sanitization functions)
    $chatId = $dating->real_escape_string($chatId);
    $senderId = $dating->real_escape_string($senderId);
    $receiverId = $dating->real_escape_string($receiverId);
    $message = $dating->real_escape_string($message);

    $sql = "INSERT INTO tbl_chats_messages (chat_id, sender_id, receiver_id, message) VALUES ('$chatId', '$senderId', '$receiverId', '$message')";

    if ($dating->query($sql) === TRUE) {

        $ResResult['status'] = 1;
        $ResResult['chats_messages_id'] = $dating->insert_id;
        $ResResult['message'] = 'Message sent successfully.';
    } else {

        $ResResult['status'] = 0;
        $ResResult['message'] = "Error: " . $sql . "<br>" . $dating->error;
    }
}

$dating->close();

echo json_encode($ResResult);
?>