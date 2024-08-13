<?php
require dirname( dirname(__FILE__) ).'/../inc/Connection.php';

$senderId = $_GET['sender_id'];
$receiverId = $_GET['receiver_id'];

// Sanitize input ...

// Fetch tbl_chats_messages from the database (adjust query as needed)
$sql = "SELECT * FROM tbl_chats_messages WHERE (sender_id = '$senderId' AND receiver_id = '$receiverId') OR (sender_id = '$receiverId' AND receiver_id = '$senderId') ORDER BY timestamp ASC"; 
$result = $dating->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $messageClass = ($row["sender_id"] == $senderId) ? 'sent' : 'received';
        echo "<div class='message $messageClass'>" . $row["message"] . "</div>";
    }
} else {
    echo "No tbl_chats_messages yet.";
}

$dating->close();
?>
