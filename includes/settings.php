<?php

$mydata = '
<style>
#signup-form {
    display: flex;
    flex-direction:column;
    max-width: 400px;
    margin: 20px;
}

#signup-form input {
    width: 100%;
    display: inline;
    margin: auto;
    padding: 5px 10px;
}

.gender {
    display: flex;
    flex-direction: column;
    align-items: start;
    justify-content: left;
    margin: 20px 0;
}

.gender div {
    display: flex;
    align-items: center;
}

#signup-form .gender input {
    width: 30px;
    display: flex;
}

#signup-form #save_button {
    background-color: #8181c3;
    color: #fff;
    border-radius: 20px;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 10px;
    width: 100px;
    text-align: center;
}

.user-photo-wrapper {
    display: flex;
    flex-direction: column;
    gap: 10px;
}    

.user-photo-wrapper img {
    width: 200px;
    height: 200px;
    margin: 20px 20px 10px;
}

#container .user-photo-wrapper input[type=button] {
    display: inline-block;
    width: 100px;
    margin-left: 20px;
    background-color: #ac7938;
    color: #fff;
    border-radius: 20px;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 5px;
    text-align: center;
}
</style>

<div style="display: flex;">
    <div class="user-photo-wrapper">
        <img src="assets/images/male.png" alt="portfolio photo" />
        <input type="button" value="Change Image" id="change_image_button">
    </div>

    <form id="signup-form" class="settings" method="POST">
        <div id="error"></div>       

        <input type="text" name="username" placeholder="Username"><br>
        <input type="text" name="email" placeholder="Email"><br>

        <div class="gender">
            <h8>Gender: </h8>
            <div>
                <input type="radio" name="gender_male" value="male"> 
                <span> Male</span>
            </div>
            <div>
                <input type="radio" name="gender_female" value="female"> 
                <span> Female</span>
            </div>
        </div>

        <input type="password" name="password" placeholder="Password"><br>
        <input type="password" name="password2" placeholder="Password Confirm"><br>
        <input type="button" value="Save" id="save_button">
    </form>
</div>';

//$result = $result[0];
$info->message = $mydata;
$info->data_type = "settings";
echo json_encode($info);

die;

$info->message = "no contacts were found...";
$info->data_type = "error";
echo json_encode($info);
