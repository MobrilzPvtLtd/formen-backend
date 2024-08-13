<?php

require dirname(dirname(__FILE__)) . '/../inc/Connection.php';

// ... (Assuming you have the $dating variable established for the database connection)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senderId = $_POST['sender_id'];
    $receiverId = $_POST['receiver_id'];
    $message = $_POST['message'];

    // Sanitize input (use appropriate sanitization functions)
    $senderId = $dating->real_escape_string($senderId);
    $receiverId = $dating->real_escape_string($receiverId);
    $message = $dating->real_escape_string($message);

    // Check if a chat already exists between these users
    $checkChatSql = "SELECT id FROM chats WHERE (user1_id = '$senderId' AND user2_id = '$receiverId') OR (user1_id = '$receiverId' AND user2_id = '$senderId')";
    $checkChatResult = $dating->query($checkChatSql);

    if ($checkChatResult->num_rows == 0) {
        // If no chat exists, create a new chat
        $createChatSql = "INSERT INTO chats (user1_id, user2_id) VALUES ('$senderId', '$receiverId')";
        if ($dating->query($createChatSql) !== TRUE) {
            $response = array('status' => 'error', 'message' => 'Error creating chat');
            header('Content-Type: application/json');
            echo json_encode($response);
            exit; // Stop further execution
        }
        $chatId = $dating->insert_id;
    } else {
        $row = $checkChatResult->fetch_assoc();
        $chatId = $row['id'];
    }

    // Now insert the message into the messages table with the chat_id
    $sql = "INSERT INTO messages (chat_id, sender_id, receiver_id, message) VALUES ('$chatId', '$senderId', '$receiverId', '$message')";

    if ($dating->query($sql) === TRUE) {
        $response = array('status' => 'success', 'message' => 'Message sent successfully');
    } else {
        $response = array('status' => 'error', 'message' => 'Error sending message');
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>