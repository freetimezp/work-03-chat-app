<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Project | Chat App | Signup</title>
</head>

<body>
    <div id="form-wrapper">
        <div class="form-header">
            <span>My Chat</span>
            <div>Login</div>
        </div>

        <form id="signup-form" method="POST">
            <div id="error"></div>

            <input type="text" name="username" placeholder="Username"><br>
            <input type="text" name="email" placeholder="Email"><br>

            <div class="gender">
                <br>Gender:<br>
                <input type="radio" name="gender" value="Male"> Male<br>
                <input type="radio" name="gender" value="Female"> Female<br>
            </div>

            <input type="password" name="password" placeholder="Password"><br>
            <input type="password" name="password2" placeholder="Password Confirm"><br>
            <input type="button" value="Sign Up" id="signup_button"><br>
        </form>
    </div>
</body>


<script src="assets/js/signup.js"></script>

</html>