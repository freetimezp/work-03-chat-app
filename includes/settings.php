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
    @keyframes appear {
        0%{
            opacity: 0;
            transform: translateY(100px);
        }
        100%{
            opacity: 1;
            transform: translateY(0px);
        }
    }

    @keyframes scaleImg {
        0%{
            opacity: 0;
            transform: scale(0.2);
        }
        100%{
            opacity: 1;
            transform: scale(1);
        }
    }

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
        border: 2px solid transparent;
    }    

    .user-photo-wrapper img {
        width: 200px;
        height: 200px;
        margin: 20px 20px 10px;
    }

    #container .user-photo-wrapper #change_image_button {
        display: inline-block;
        width: 140px;
        margin: 0 auto;
        background-color: #ac7938;
        color: #fff;
        border-radius: 20px;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 5px;
        text-align: center;
    }

    .dragging {
        border: 2px dashed #eee;
    }

    small {
        max-width: 200px;
        display: block;
        margin: 0 auto;
    }
    </style>

    <div style="display: flex;">
        <div class="user-photo-wrapper" style="animation: scaleImg 0.5s ease-out;">
            <img src="' . $image . '" alt="portfolio photo" ondragover="handle_drag_and_drop(event)" ondragleave="handle_drag_and_drop(event)" ondrop="handle_drag_and_drop(event)" />
            <small>* ease drag & drop your image to change portfolio avatar</small>

            <label id="change_image_button" for="change_image_input">
                Change Image                
            </label>
            <input type="file" value="Change Image" id="change_image_input" 
                onchange="upload_profile_image(this.files)">
        </div>

        <form id="profile-form" class="settings" method="POST" style="animation: appear 0.5s ease-out;">
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

    $info->message = $mydata;
    $info->data_type = "contacts";
    echo json_encode($info);
} else {
    $info->message = "no contacts were found...";
    $info->data_type = "error";
    echo json_encode($info);
}
