function __(element) {
    return document.getElementById(element);
}

var logoutBtn = __("logout");
if (logoutBtn) {
    logoutBtn.addEventListener("click", logout);
}

function logout() {
    var answer = confirm("Are you sure you want to log out?");

    if (answer) {
        get_data({}, "logout");
    }
};

var label_contacts = __("label_contacts");
if (label_contacts) {
    label_contacts.addEventListener("click", get_contacts);
}
var label_chat = __("label_chat");
if (label_chat) {
    label_chat.addEventListener("click", get_chats);
}
var label_settings = __("label_settings");
if (label_settings) {
    label_settings.addEventListener("click", get_settings);
}

function get_data(find, type) {
    var xml = new XMLHttpRequest();

    var loader_holder = __("loader_holder");
    loader_holder.className = "loader_on";

    xml.onload = function () {
        if (xml.readyState == 4 || xml.status == 200) {
            loader_holder.className = "loader_off";

            handle_result(xml.responseText, type);
        }
    };

    var data = {};
    data.find = find;
    data.data_type = type;
    data = JSON.stringify(data);

    xml.open("POST", "api.php", true);
    xml.send(data);
}

function handle_result(result, type) {
    if (result.trim() != "") {
        var obj = JSON.parse(result);

        //console.log(obj);
        if (typeof (obj.logged_in) != "undefined" && !obj.logged_in) {
            window.location = 'login.php';
        } else {
            //alert(result.data_type);

            switch (obj.data_type) {
                case "user_info":
                    var username = __("username");
                    var email = __("email");
                    var profile_image = __("user_photo_image");
                    username.innerHTML = obj.username;
                    email.innerHTML = obj.email;

                    profile_image.src = obj.image;

                    break;

                case "contacts":
                    var inner_left_pannel = __("inner_left_pannel");
                    inner_left_pannel.innerHTML = obj.message;
                    break;

                case "chats":
                    var inner_left_pannel = __("inner_left_pannel");
                    inner_left_pannel.innerHTML = obj.message;
                    break;

                case "settings":
                    var inner_left_pannel = __("inner_left_pannel");
                    inner_left_pannel.innerHTML = obj.message;
                    settings_func();
                    break;

                case "save_settings":
                    //alert(obj.message);
                    get_settings(true);
                    get_data({}, "user_info");
                    break;
            }
        }
    }
}

get_data({}, "user_info");

function get_contacts(e) {
    get_data({}, "contacts");
}

function get_chats(e) {
    get_data({}, "chats");
}

function get_settings(e) {
    get_data({}, "settings");
}

function settings_func() {
    var save_button = __("save_button");

    if (save_button) {
        save_button.addEventListener("click", collect_updated_data);
    }

    function collect_updated_data(e) {
        e.preventDefault();

        save_button.disabled = true;
        save_button.value = "Loading...";

        var myForm = __("profile-form");
        var inputs = myForm.getElementsByTagName("input");

        var data = {};
        for (var i = inputs.length - 1; i >= 0; i--) {
            var key = inputs[i].name;

            switch (key) {
                case "username":
                    data.username = inputs[i].value;
                    break;

                case "email":
                    data.email = inputs[i].value;
                    break;

                case "gender":
                    if (inputs[i].checked) {
                        data.gender = inputs[i].value;
                    }
                    break;

                case "password":
                    data.password = inputs[i].value;
                    break;

                case "password2":
                    data.password2 = inputs[i].value;
                    break;
            }
        }

        send_updated_data(data, "save_settings");
    }

    function send_updated_data(data, type) {
        var xml = new XMLHttpRequest();

        xml.onload = function () {
            if (xml.status == 200 || xml.readyState == 4) {
                //alert(xml.responseText);
                handle_result(xml.responseText);

                save_button.disabled = false;
                save_button.value = "Save";

                get_settings(true);
                get_data({}, "user_info");
            }
        }

        data.data_type = type;
        var data_string = JSON.stringify(data);

        xml.open("POST", "api.php", true);
        xml.send(data_string);
    }
}


function upload_profile_image(files) {
    var xml = new XMLHttpRequest();

    var change_image_button = __("change_image_button");
    change_image_button.disabled = true;
    change_image_button.innerHTML = "Uploading Image";

    var myForm = new FormData();

    xml.onload = function () {
        if (xml.status == 200 || xml.readyState == 4) {
            //alert(xml.responseText);

            get_data({}, "user_info");
            get_settings(true);

            change_image_button.disabled = false;
            change_image_button.innerHTML = "Change Image";
        }
    }

    myForm.append("file", files[0]);
    myForm.append("data_type", 'change_profile_image');

    xml.open("POST", "uploader.php", true);
    xml.send(myForm);
}
