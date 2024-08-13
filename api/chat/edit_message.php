<?php

require dirname(dirname(__FILE__)) . '/../inc/Connection.php';
// ... (Assuming you have the $dating variable established for the database connection)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $messageId = $_POST['message_id'];
    $newMessage = $_POST['new_message'];

    // Sanitize input ...

    $sql = "UPDATE messages SET message = '$newMessage' WHERE id = '$messageId'";

    if ($dating->query($sql) === TRUE) {
        $response = array('status' => 'success', 'message' => 'Message edited successfully');
    } else {
        $response = array('status' => 'error', 'message' => 'Error editing message');
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

// ... (Assuming the connection is closed elsewhere in your code)
?>
