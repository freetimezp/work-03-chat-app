<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link
        href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Project | Chat App</title>
</head>

<body>
    <div id="wrapper">
        <div id="left_pannel">
            <div class="left_pannel_avatar" id="user_info">
                <img src="assets/images/male.png" alt="profile">
                <br>
                <span class="avatar_name" id="username">Username</span>
                <br>
                <span class="avatar_email" id="email">profile@gmail.com</span>
            </div>

            <div class="left_pannel_labels">
                <label for="radio_chat" id="label_chat">
                    <span>Chat</span>
                    <i class="ri-chat-1-line"></i>
                </label>
                <label for="radio_contacts" id="label_contacts">
                    <span>Contacts</span>
                    <i class="ri-contacts-book-line"></i>
                </label>
                <label for="radio_settings" id="label_settings">
                    <span>Settings</span>
                    <i class="ri-tools-fill"></i>
                </label>
            </div>
        </div>

        <div id="right_pannel">
            <div id="header">My Chat</div>

            <div id="container">
                <div id="inner_left_pannel">

                </div>

                <input type="radio" name="myradio" id="radio_chat">
                <input type="radio" name="myradio" id="radio_contacts">
                <input type="radio" name="myradio" id="radio_settings">


                <div id="inner_right_pannel">

                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>

</html>