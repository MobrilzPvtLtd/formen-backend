<!DOCTYPE html>
<html>
<head>
    <title>Live Chat</title>
    <link rel="stylesheet" href="style.css"> </head>
<body>

    <div id="chat-container">
        <div id="chat-messages">
            </div>
    </div>

    <div id="input-area">
        <input type="text" id="message-input" placeholder="Type your message...">
        <button id="send-button">Send</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
    // Replace with actual user IDs (you'll need to implement user authentication)
    var chatId = 1; 
    var senderId = 2; 
    var receiverId = 1; 

    // Function to send a message via AJAX
    function sendMessage() {
        var message = $('#message-input').val();
        if (message.trim() === '') return; // Don't send empty messages

        $.ajax({
            type: 'POST',
            url: 'send_message.php', // Your PHP script
            data: { 
                chat_id: chatId, 
                sender_id: senderId, 
                receiver_id: receiverId, 
                message: message 
            },
            success: function(response) {
                $('#message-input').val(''); // Clear input field
                displayMessage(message, true); // Display sent message immediately
                getMessages(); // Fetch updated messages
            },
            error: function() {
                alert('Error sending message. Please try again.');
            }
        });
    }

    // Function to fetch messages from the server
    function getMessages() {
        $.ajax({
            type: 'GET',
            url: 'get_messages.php', // Your PHP script
            data: { 
                sender_id: senderId, 
                receiver_id: receiverId 
            },
            success: function(response) {
                // If your PHP script returns only new messages, append them instead of replacing
                if (isNewMessageResponse(response)) { 
                    $('#chat-messages').append(response); 
                } else {
                    // If the response contains all messages, replace the entire content
                    $('#chat-messages').html(response); 
                }
                $('#chat-container').scrollTop($('#chat-container')[0].scrollHeight); // Scroll to bottom
            },
            error: function() {
                // Handle error (e.g., display an error message)
            }
        });
    }

    // Function to determine if the response contains only new messages
    // You'll need to implement this based on the actual response format from your PHP script
    function isNewMessageResponse(response) {
        // Example: If your PHP script wraps new messages in a specific container, you can check for that
        return $(response).find('.new-message-container').length > 0; 
    }

    // Function to display a new message in the chat
    function displayMessage(message, isSent) {
        var messageClass = isSent ? 'sent' : 'received';
        var newMessage = $('<div class="message ' + messageClass + '">' + message + '</div>');
        $('#chat-messages').append(newMessage);
    }

    // Send message on button click or Enter key press
    $('#send-button').click(sendMessage);
    $('#message-input').keypress(function(e) {
        if (e.which === 13) { // Enter key
            sendMessage();
        }
    });

    // Initial fetch of messages
    getMessages();

    // Poll for new messages every few seconds (adjust interval as needed)
    setInterval(getMessages, 3000); 
});

    </script>

</body>
</html>