<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Project | Chat App | Login</title>
</head>

<body>
    <div id="form-wrapper">
        <div class="form-header">
            <span>My Chat</span>
            <div>Login</div>
        </div>

        <form id="login-form" method="POST">
            <div id="error"></div>

            <input type="text" name="email" placeholder="Email"><br>
            <input type="password" name="password" placeholder="Password"><br>

            <input type="button" value="Login" id="login_button"><br>
        </form>
    </div>
</body>


<script src="assets/js/login.js"></script>

</html>