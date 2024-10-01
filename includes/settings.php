<?php

$query = "SELECT * FROM users WHERE user_id = :user_id LIMIT 1";
$id = $_SESSION['user_id'];

$data = $DB->read($query, ['user_id' => $id]);

$mydata = "";

if (is_array($data)) {
    $data = $data[0];
    $gender_male = "";
    $gender_female = "";

    //check if profile image exist
    $image = ($data->gender == 'male') ? 'assets/images/male.png' : 'assets/images/female.png';
    if (file_exists($data->image)) {
        $image = $data->image;
    }

    if ($data->gender == "male") {
        $gender_male = " checked ";
    } else {
        $gender_female = " checked ";
    }

    $mydata = '
    <style>
    #profile-form {
        display: flex;
        flex-direction:column;
        max-width: 400px;
        margin: 20px;
    }

    #profile-form input {
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

    #profile-form .gender input {
        width: 30px;
        display: flex;
    }

    #profile-form #save_button {
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
            <img src="' . $image . '" alt="portfolio photo" />
            <input type="button" value="Change Image" id="change_image_button">
        </div>

        <form id="profile-form" class="settings" method="POST">
            <div id="error"></div>       

            <input type="text" name="username" placeholder="Username" value="' . $data->username . '"><br>
            <input type="text" name="email" placeholder="Email" value="' . $data->email . '"><br>

            <div class="gender">
                <h8>Gender: </h8>
                <div>
                    <input type="radio" name="gender" value="male" ' . $gender_male . '> 
                    <span> Male</span>
                </div>
                <div>
                    <input type="radio" name="gender" value="female" ' . $gender_female . '> 
                    <span> Female</span>
                </div>
            </div>

            <input type="password" name="password" placeholder="Password" value="' . $data->password . '"><br>
            <input type="password" name="password2" placeholder="Password Confirm" value="' . $data->password . '"><br>
            <input type="button" value="Save" id="save_button">
        </form>
    </div>';
}
//$result = $result[0];
$info->message = $mydata;
$info->data_type = "settings";
echo json_encode($info);

die;

$info->message = "no contacts were found...";
$info->data_type = "error";
echo json_encode($info);
