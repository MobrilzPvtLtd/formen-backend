<?php
// Database connection (replace with your actual credentials)
require dirname( dirname(__FILE__) ).'.../inc/Connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senderId = $_POST['sender_id'];
    $receiverId = $_POST['receiver_id'];
    $message = $_POST['message'];

    // Sanitize input (use appropriate sanitization functions)
    $senderId = $dating->real_escape_string($senderId);
    $receiverId = $dating->real_escape_string($receiverId);
    $message = $dating->real_escape_string($message);

    $sql = "INSERT INTO tbl_chats_messages (sender_id, receiver_id, message) VALUES ('$senderId', '$receiverId', '$message')";

    if ($dating->query($sql) === TRUE) {
        echo "Message sent successfully"; // Or any other success response
    } else {
        echo "Error: " . $sql . "<br>" . $dating->error;
    }
}

$dating->close();
?>
