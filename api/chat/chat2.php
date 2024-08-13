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
            // Replace with actual user IDs 
            var senderId = 2; 
            var receiverId = 1; 

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
                                var messageId = messages[i].id; 
                                displayMessage(message, isSent, messageId);
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

            // Function to display a new message in the chat (modified)
            function displayMessage(message, isSent, messageId) { 
                var messageClass = isSent ? 'sent' : 'received';
                var newMessage = $('<div class="message ' + messageClass + '" data-message-id="' + messageId + '">' + message);

                if (isSent) {
                    var editButton = $('<button class="edit-button">Edit</button>');
                    newMessage.append(editButton); 

                    editButton.click(function() {
                        var messageDiv = $(this).parent();
                        var originalMessage = messageDiv.text().trim(); 

                        var editInput = $('<input type="text" value="' + originalMessage + '">');
                        var saveButton = $('<button class="save-button">Save</button>');

                        messageDiv.empty().append(editInput).append(saveButton);

                        saveButton.click(function() {
                            var newMessageText = editInput.val();
                            var messageId = messageDiv.data('message-id');

                            $.ajax({
                                type: 'POST',
                                url: 'edit_message.php', 
                                data: { 
                                    message_id: messageId,
                                    new_message: newMessageText
                                },
                                success: function(response) {
                                    if (response.status === 'success') {
                                        messageDiv.empty().text(newMessageText).append(editButton); 
                                        getMessages(); 
                                    } else {
                                        alert(response.message); 
                                    }
                                },
                                error: function() {
                                    alert('Error editing message. Please try again.');
                                }
                            });
                        });
                    });
                }

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
