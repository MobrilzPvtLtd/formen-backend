<!DOCTYPE html>
<html>
<head>
    <title>Live Chat</title>
    <link rel="stylesheet" href="style.css"> 
</head>
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
            var senderId = 1; 
            var receiverId = 2; 

            // Function to send a message via AJAX
            function sendMessage() {
                var message = $('#message-input').val();
                if (message.trim() === '') return;

                $.ajax({
                    type: 'POST',
                    url: 'send_message.php',
                    data: { 
                        sender_id: senderId, 
                        receiver_id: receiverId, 
                        message: message 
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#message-input').val('');
                            displayMessage(message, true); 
                            getMessages(); 
                        } else {
                            alert(response.message); 
                        }
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
                    url: 'get_messages.php',
                    data: { 
                        sender_id: senderId, 
                        receiver_id: receiverId 
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            var messages = response.messages;
                            $('#chat-messages').empty();

                            for (var i = 0; i < messages.length; i++) {
                                var message = messages[i].message;
                                var isSent = (messages[i].sender_id == senderId);
                                displayMessage(message, isSent);
                            }

                            $('#chat-container').scrollTop($('#chat-container')[0].scrollHeight);
                        } else {
                            // Handle error
                        }
                    },
                    error: function() {
                        // Handle error
                    }
                });
            }

            // Function to determine if the response contains only new messages
            function isNewMessageResponse(response) {
                // Example: If your PHP script wraps new messages in a specific container
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
                if (e.which === 13) {
                    sendMessage();
                }
            });

            // Initial fetch of messages
            getMessages();

            // Poll for new messages every few seconds
            setInterval(getMessages, 3000); 
        });
    </script>

</body>
</html>
