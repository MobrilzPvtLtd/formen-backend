<?php
// Database connection (replace with your actual credentials)
require dirname(dirname(__FILE__)) . '/../inc/Connection.php';

$ResResult = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senderId = $_POST['sender_id'];
    $receiverId = $_POST['receiver_id'];

    $result = $dating->query("SELECT * FROM tbl_chats WHERE (sender_id = '$senderId' AND receiver_id = '$receiverId') OR (sender_id = '$receiverId' AND receiver_id = '$senderId')");

    if ($result->num_rows > 0) {

        $ResResult['status'] = 0;
        $ResResult['chat_id'] = $result->fetch_assoc()['id'];
        $ResResult['message'] = 'Chat already started';

    } else {
        $result = $dating->query("INSERT INTO tbl_chats (sender_id, receiver_id) VALUES ('$senderId', '$receiverId')");

        $ResResult['status'] = 0;
        $ResResult['chat_id'] = $dating->insert_id;
        $ResResult['message'] = 'Chat started';
    }
}

$dating->close();

echo json_encode($ResResult);

?>