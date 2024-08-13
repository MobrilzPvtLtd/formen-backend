<?php
require dirname(dirname(__FILE__)) . '/../inc/Connection.php';

$ResResult = array();

$senderId = $_GET['sender_id'];
$receiverId = $_GET['receiver_id'];

// Sanitize input ...

// Fetch tbl_chats_messages from the database (adjust query as needed)
$sql = "SELECT * FROM tbl_chats_messages WHERE (sender_id = '$senderId' AND receiver_id = '$receiverId') OR (sender_id = '$receiverId' AND receiver_id = '$senderId') ORDER BY timestamp ASC";
$result = $dating->query($sql);

if ($result->num_rows > 0) {

    $ResResult['status'] = 1;

    while ($row = $result->fetch_assoc()) {

        $ChatInst = array();

        $ChatInst['sender_id'] = $row["sender_id"];

        $ChatInst['message'] = $row["message"];

        $messageClass = ($row["sender_id"] == $senderId) ? 'sent' : 'received';

        $ChatInst['type'] = $messageClass;

        $ResResult['chats'][] = $ChatInst;
    }

} else {
    $ResResult['status'] = 0;
    $ResResult['message'] = "No messages yet.";
}

$dating->close();
?>